# Architecture

Target architecture of the modernised Measuring Well-Being (SDQ) platform. The decision record is in [SYSTEM_REVIEW_REPORT.md](SYSTEM_REVIEW_REPORT.md); this document describes what is being built.

## 1. Why "evolve" (Option A)

The legacy system is a Laravel 5.8 monolith with a small, clear data model and years of production data whose semantics (statuses, codes, scoring) partners are trained on. Rebuilding on a different stack would force a re-derivation of every rule and a riskier data translation. Evolving keeps:

- the database table and column names, so the production dump restores as is and migrations only add;
- the workflow states, code format and quotas the field teams know;
- the ability to keep the existing Android APK working against a compatibility API during the transition.

What changes: the framework (Laravel 13 on PHP 8.3), the UI (Inertia + Vue 3 + Tailwind, bilingual with RTL), the API (Sanctum tokens and an idempotent sync endpoint), server-side code generation and scoring in one tested service, containers, and Azure hosting with CI/CD.

## 2. System context

```mermaid
flowchart LR
    subgraph Users
        A[UNICEF admin]
        P[Partner NGO]
        C[Field collector]
    end
    subgraph Clients
        W[Web app<br/>Inertia / Vue]
        M1[Legacy Android APK<br/>offline SQLite]
        M2[New mobile app<br/>planned]
    end
    subgraph Azure["Azure (Container Apps environment)"]
        WEB[web container<br/>FrankenPHP]
        WRK[worker container<br/>queue:work]
        SCH[scheduler container<br/>schedule:work]
        JOB[migrate job]
        DB[(MySQL Flexible Server)]
        KV[Key Vault]
        ST[Blob Storage]
        AI[App Insights / Log Analytics]
        ACR[Container Registry]
    end
    A & P --> W --> WEB
    C --> W
    C --> M1 -->|/api/* token param| WEB
    C -.-> M2 -.->|/api/v1 bearer| WEB
    WEB & WRK & SCH & JOB --> DB
    WEB & WRK & SCH & JOB -.secrets.-> KV
    WEB --> ST
    WEB & WRK & SCH --> AI
    ACR -->|image| WEB & WRK & SCH & JOB
    SMTP[(SMTP relay)] <-- WRK
```

One image, four roles. `docker/entrypoint.sh` reads `CONTAINER_ROLE`:

| Role | Command | Replicas |
|---|---|---|
| `web` | FrankenPHP serving `public/` on 8080, health at `/up` | 1 to 5 (0 to 2 on staging) |
| `worker` | `php artisan queue:work` (mail, notifications) | 1 |
| `scheduler` | `php artisan schedule:work` | 1 |
| `migrate` | `php artisan migrate --force` + reference seeders, then exits | Container Apps job, run by the pipeline before each deploy |

## 3. Request flow

1. Browser requests a page. `routes/web.php` dispatches to a controller; `HandleInertiaRequests` shares the user, roles, locale, translations and flash messages; the controller returns an Inertia page with props; Vue renders it. Subsequent navigation is XHR with JSON props.
2. The mobile client calls `/api/v1/*` with a Sanctum bearer token, or the legacy APK calls `/api/*` with its `token` parameter (see section 8).
3. All writes to applications go through `App\Sdq\ApplicationService`, whatever the channel.
4. Mail and other slow work is queued (database queue) and executed by the worker.

## 4. Roles and visibility

| Role | Sees | Does |
|---|---|---|
| `admin` (UNICEF) | everything | manages partners, administrators, statuses, locations; analytics and export over all data |
| `partner` (NGO) | its own applications (its `user_id` is the `partner_id`, plus its collectors' applications) | manages its collectors, transfers applications, explains decreases, analytics and export over its data |
| `collector` | its own applications | creates applications, fills pre- and post-tests (web or mobile) |

`Application::visibleTo($user)` is the single scope that enforces this in every query. Flags `is_active` (may sign in) and `is_readonly` (may sign in but not write) are kept from the legacy model.

## 5. Data model

Table names are the legacy ones. Relations use the legacy convention that `collectors.partner_id` and `application.partner_id` hold the partner's **user id**.

```
users ──1:1── partners (user_id, name, prefix, logo, max_app_per_year)
users ──1:1── collectors (user_id, partner_id -> users.id of partner, prefix, city, sub-partner)
application (code, year, sequence, client_uuid, partner_id, collector_id, status -> status.id,
             pre_test_date, post_test_date, reason_option, reason_details, soft deletes)
   ├─ application_value type=pre_test  (demographics, location ids, 25 items, 5 scale columns, score, na_count)
   ├─ application_value type=post_test (same + hours attended, dropout reason)
   └─ application_log (causer_id, text)
gouvernate ─< caza ─< area        (ids identical to the legacy dump; application_value stores them as text)
status, forms                      (reference)
roles / permissions tables         (spatie/laravel-permission, guard "web")
personal_access_tokens             (Sanctum, new mobile app)
```

Migrations: `0000_01_01_000000_create_legacy_baseline_tables` creates every legacy table only if missing (no-op on a restored dump); `0000_01_01_000001_modernise_legacy_schema` adds the columns the legacy code used but never migrated (`collectors.prefix`, scale columns, `na_count`, `reason_*`, `users.api_token`, `application_log`), the new columns (`year`, `sequence`, `client_uuid`, `is_readonly`, `locale`, `deleted_at`), indexes, and renames role guards `admin` to `web`. Everything is additive; nothing is dropped on rollback.

## 6. Workflow and statuses

```
New ─ Pre Test ─┬─ (save) ─ Pre Test Pending ─┐
                └─ (submit) ──────────────────┴─ Post Test ─┬─ (save) ─ Post Test Pending ─┐
                                                             └─ (submit) ─────────────────┴─ Done
Branches: consent refused ─ Pre/Post Test No Permission · more than 3 NA answers ─ NA · dropout reason ─ Dropout
```

`App\Sdq\ApplicationStatus` holds the names; `Status::idOf()` maps them to the `status` table, which keeps the legacy ids 2 to 9 where they existed. Transitions, scoring, quota and audit-log entries live in `ApplicationService` and are covered by `tests/Feature/ApplicationWorkflowTest.php`.

## 7. Scoring policy (decision for UNICEF)

`App\Sdq\SdqScorer` implements two policies selected by `SDQ_SCORING_POLICY`:

| Policy | Scale formula | Where it comes from |
|---|---|---|
| `documented` (default) | average of the scale's answered items x 5 + 0.5, NA items omitted | UNICEF scoring document (`docs/original/SDQ_Scoring_Explanation.docx`) |
| `legacy` | sum of answered items + 0.5 (the division was never applied) | what `legacy/app/Application.php::countScore()` actually computed |

The two agree whenever a questionnaire has no NA answers. Total = emotional + conduct + hyperactivity + peer problems (pro-social excluded). A lower total after the programme is an improvement and is reported as "Increase". Run the reference comparison with `legacy` to reproduce historical numbers, then decide whether historical scores are frozen as stored or re-scored (see the runbook).

## 8. Code generation and sync

- Codes are `{year}-{PARTNER}-{COLLECTOR}-{n}` (configurable), generated **on the server** inside a transaction with a row lock on the collector (`ApplicationCodeGenerator`). `n` is a per-collector running number stored in `application.sequence`; collisions with pre-existing codes are skipped.
- Mobile clients create applications with a `client_uuid`. Re-sending the same uuid returns the existing application, so retries and offline queues cannot create duplicates (`ApplicationService::create`). `/api/v1/sync` applies a batch of operations with that rule.
- The legacy APK still generates codes on the device. The compatibility routes under `/api/*` accept its payloads unchanged, authenticate with `users.api_token` (`AuthenticateLegacyApiToken`), and call the same `ApplicationService`, so its submissions are validated, scored and logged exactly like web ones. Codes it sends are honoured if free; the warning in the technical doc about mixing app and web remains valid for the old APK only.

## 9. Environments and configuration

| | local | staging | prod |
|---|---|---|---|
| Runs | `docker compose` (MySQL 8.4, Mailpit) or `php artisan serve` with SQLite | Container Apps `rg-mwb-staging` | Container Apps `rg-mwb-prod` |
| Data | seeders | copy of production dump | production |
| Scale | - | web 0 to 2 | web 1 to 5 |
| Mail | Mailpit | log driver until SMTP is set | SMTP relay |

All configuration is environment variables (`.env.example` documents them). In Azure the Bicep template sets them on the container apps; `APP_KEY`, `DB_PASSWORD`, `MAIL_PASSWORD` are Key Vault references resolved by the user-assigned managed identity. MySQL Flexible Server enforces TLS: `MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt` is set and read by `config/database.php`.

## 10. Observability and backups

- Container stdout/stderr and the Laravel `stderr` log channel go to Log Analytics; Application Insights receives request telemetry (connection string exposed to the app; server-side SDK instrumentation is a follow-up).
- Health: `/up` is used by the startup, liveness and readiness probes and by the deploy smoke test.
- MySQL Flexible Server automated backups: 7 days on staging, 35 days geo-redundant on production; point-in-time restore from the portal or `az mysql flexible-server restore`.
- Partner logos and exports are on the web container's local disk for now (ephemeral across revisions). The Blob Storage account and `public`/`exports` containers are provisioned; wiring Laravel's filesystem to them is a listed follow-up.

## 11. Security notes

- Passwords are bcrypt; accounts are created inactive and activated through an emailed set-up link (7-day token). Password reset uses Laravel's broker.
- Web: session cookies (secure in Azure), CSRF on every form, role middleware on every admin/partner route, rate limiting on login and password reset.
- API v1: Sanctum tokens revocable per device; legacy `api_token` is accepted only on the compatibility routes and should be retired with the old APK.
- No secrets in the repository or image; Key Vault with RBAC, purge protection on.
- Dependabot keeps GitHub Actions current; Composer and npm updates are reviewed through CI.
