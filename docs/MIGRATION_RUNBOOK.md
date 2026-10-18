# Migration runbook: GoDaddy to Azure

Step-by-step procedure to move the Measuring Well-Being platform from the GoDaddy shared host to Azure Container Apps with the modernised application. Each step names an owner and what "done" looks like.

## 0. Prerequisites and owners

| Role | Who (to fill in) | Responsible for |
|---|---|---|
| Product owner | UNICEF Child Protection / IM focal point | decisions (scoring policy, cutover date), partner communication, UAT sign-off |
| Technical lead | Innovation team | runs this runbook, owns the Azure subscription resource groups |
| Hosting admin | current GoDaddy account holder | exports, DNS changes, FTP credential rotation, decommissioning |
| Partner UAT leads | two partner organisations | UAT scenarios on staging |

RACI summary: R = technical lead, A = product owner, C = hosting admin and partner leads, I = all partners (cutover notice).

Before starting:

- [ ] Azure subscription with permission to create resource groups; `az` CLI 2.60+ with the `containerapp` extension and Bicep.
- [ ] GitHub repository secrets and variables set as in `infra/README.md`.
- [ ] Access to GoDaddy cPanel/phpMyAdmin and FTP for the `prod` and `staging` folders.
- [ ] The Android source zip (`androidapp.zip`) located and archived in a private storage container.
- [ ] Decision taken on the scoring policy (section 4) or explicitly deferred.

## 1. Export production (hosting admin, 1 hour)

From the GoDaddy host, via SSH/cPanel terminal (preferred over phpMyAdmin for size and charset safety):

```bash
mysqldump --user="$DB_USER" --password --host=localhost \
  --default-character-set=utf8mb4 --single-transaction --routines --triggers \
  --hex-blob --no-tablespaces "$DB_NAME" > prod_$(date +%Y%m%d).sql
gzip prod_*.sql
```

(`DB_*` values are in `/home/<account>/public_html/prod/.env`.) Also take:

- `public_html/prod/public/images/partner_logo/` (partner logos),
- `public_html/prod/public/apk/` (every `sdqX.apk`, keep the newest at least),
- `public_html/prod/.env` (for MAIL_* values only; do not commit),
- a screenshot of the admin dashboard and the applications list count, as a first reference.

Store the archive in the `exports` blob container of the staging storage account or another private location. Record the SHA-256 of the dump.

Done when: dump + logos + APK are in private storage, size and hash recorded.

## 2. Load the legacy reference environment (technical lead, 1 hour)

Follow `legacy/README.md`:

```bash
cd legacy && cp .env.example .env && docker compose up -d --build
docker compose exec legacy-app php artisan key:generate
./docker/import-dump.sh ../prod_YYYYMMDD.sql
```

Sign in with an existing admin account (reset the password in the DB if needed: `UPDATE users SET password='<bcrypt>' WHERE email=...`). Capture the **reference numbers** and keep them with the dump:

- total applications, and counts per status (`SELECT status, COUNT(*) FROM application GROUP BY status`);
- counts per partner (dashboard table) for the current year and all years;
- the full CSV export from Applications > Export (all partners);
- screenshots of every analytics page;
- `SELECT COUNT(*), MIN(created_at), MAX(created_at) FROM application_log`.

Done when: the legacy app runs locally on the production dump and the reference pack is saved.

## 3. Restore into Azure staging and migrate (technical lead, 2 hours)

Infrastructure:

```bash
# first time only; see infra/README.md for secrets
az deployment group create -g rg-mwb-staging -f infra/main.bicep -p infra/params/staging.bicepparam
```

Restore the dump (temporarily add your IP to `mysqlAllowedIpRanges` or use the Azure Cloud Shell):

```bash
MYSQL=mwb-staging-mysql.mysql.database.azure.com
mysql --host=$MYSQL --user=sdqadmin --password --ssl-mode=REQUIRED sdq < prod_YYYYMMDD.sql
```

Then run the migrate job (the deploy workflow does this automatically; by hand):

```bash
az containerapp job start -g rg-mwb-staging -n mwb-staging-migrate
az containerapp job execution list -g rg-mwb-staging -n mwb-staging-migrate -o table
```

What the job does on a restored dump, in order:

1. `create_legacy_baseline_tables`: every table already exists, so it creates nothing.
2. `modernise_legacy_schema`: adds only the missing columns and indexes, creates `application_log` if the dump lacks it, renames role guards `admin` to `web`, back-fills `application.year` from the pre-test date.
3. Sanctum and cache/jobs tables are created.
4. `RoleSeeder`, `StatusSeeder` (adds "Dropout", "NA", "No Permission" rows by name if missing), `LocationSeeder` (updates names, inserts areas only if the table is empty) and `AdminUserSeeder` (creates the first admin from `SDQ_ADMIN_EMAIL`/`SDQ_ADMIN_PASSWORD` if set on the job).

Existing users keep their bcrypt passwords and can sign in unchanged. Legacy `api_token` values keep working for the old APK.

Done when: the job execution shows `Succeeded`, `https://<staging fqdn>/up` is 200 and an admin can sign in.

## 4. Verification against the reference (technical lead + product owner, half a day)

Run the same checks on staging as in step 2 and compare:

| Check | Expected |
|---|---|
| Applications per status, per partner, per year | identical to the reference pack |
| Applications list for one partner account | same rows as legacy for that partner |
| CSV export | same number of data rows (two per application with a post-test, one otherwise); columns are a superset of the legacy export (adds Year, Other Nationality, NA count) |
| Scores of 20 sampled applications (`score`, five scale columns) | identical to legacy. Scores are stored, not recomputed, so this must match exactly |
| Scoring of a **new** test submission | equals the legacy result when `SDQ_SCORING_POLICY=legacy`; equals the UNICEF formula when `documented` (differs only when NA answers are present) |
| Analytics pages | same figures as the screenshots (allowing for the legacy "application range" session filter being off) |
| Legacy APK pointed at staging (`https://<staging fqdn>/api/`) | login, list, pre-test and post-test submission succeed |

CSV comparison approach: export from both, sort by `Code` and `Type`, strip the added columns, then `diff`; or load both into pandas with `read_csv(dtype=str)` and compare on the common columns.

**Scoring decision:** present the product owner with the difference between the two policies on the sample. Options: (a) keep stored historical scores and score new tests with `documented`; (b) run everything as `legacy` for continuity; (c) re-score history with `documented` (a one-off artisan command would be written for this). Record the decision in `docs/README.md` and set `sdqScoringPolicy` in `infra/params/prod.bicepparam` accordingly.

Done when: every row above matches or has an explained, accepted difference, and the scoring decision is recorded.

## 5. UAT with two partners (product owner, 1 week)

Create UAT accounts on staging for two partner organisations (one with collectors using the web form, one using the old APK). Scenarios: sign in, create collector, create application, pre-test (save then submit), post-test with and without dropout, decrease justification, export, analytics, Arabic UI. Collect issues in GitHub, fix on `main` (auto-deploys to staging).

Done when: both partners sign off in writing.

## 6. Mobile application plan (technical lead)

- The deployed APK (version 10) keeps working through the legacy API routes, pointed at the new domain once DNS switches. No change is needed on devices as long as the hostname stays `measuringwellbeing.org`. If the APK has the path `/prod/api/` hard-coded, add a rewrite from `/prod/api/*` to `/api/*` in `docker/Caddyfile` before cutover and test with step 4.
- Host the APK at `SDQ_APK_URL` (Blob `public` container with anonymous blob read, or the app's `public/apk` folder).
- A new mobile app (Flutter or React Native, offline-first) targets `/api/v1` with the sync contract in `docs/API.md`; schedule it after cutover.

## 7. Cutover (all, one evening + monitoring)

Go/no-go checklist, reviewed the day before:

- [ ] Production infrastructure deployed (`infra/params/prod.bicepparam`), secrets set, SMTP tested with a real mail.
- [ ] Production image deployed to prod from `main` via the Deploy workflow (prod environment approved).
- [ ] Custom domain `measuringwellbeing.org` added to the web app and the `asuid` TXT record in place (see `infra/README.md`); managed certificate issued for a test subdomain first (`new.measuringwellbeing.org`).
- [ ] Partners notified of a 2-hour freeze window; collectors asked to sync their devices before it.
- [ ] Rollback plan (section 8) read by the people on duty.

Sequence:

1. **Freeze** (T0): put the GoDaddy app in maintenance mode (`php artisan down` in `public_html/prod`).
2. **Final dump**: repeat step 1 (full dump, not a delta, it is small); copy logos again.
3. **Restore into prod MySQL** and run the migrate job (step 3 commands with `rg-mwb-prod`).
4. **Verify** the counts against the fresh dump (step 4 first row) and sign in as admin.
5. **DNS**: switch `measuringwellbeing.org` (and `prod.`, `staging.` if used by the APK) to the Container Apps web app; bind the managed certificate. TTL should have been lowered to 300 s a day earlier.
6. **Mail**: confirm a password-reset mail arrives from the new platform.
7. **Announce** to partners: same URL, same credentials, same APK.
8. **Rotate** the GoDaddy FTP password printed in the technical PDF, and the GoDaddy DB password.
9. Keep GoDaddy in maintenance mode for 30 days as a fallback, then cancel hosting; keep the final dump for 1 year.

Monitoring for the first week: Log Analytics query for 5xx (see `OPERATIONS.md`), failed job executions, MySQL CPU, mail delivery.

## 8. Rollback

Trigger: a blocking defect found within the first days that cannot be hot-fixed.

1. Switch DNS back to GoDaddy (TTL 300 s) and run `php artisan up` there.
2. Data written on Azure since T0 is in the Azure database. Export the delta (`application`, `application_value`, `application_log`, `users`, `collectors` rows created after T0) and import it into GoDaddy with a reviewed script; or accept re-entry if the window was short. Decide this at go/no-go time and write it down.
3. Keep the Azure environment running for diagnosis; do not delete the resource group.

## 9. After cutover

- Remove the legacy API routes once the new mobile app has replaced the APK on every device.
- Wire Blob Storage for logos/exports, add alerting and a budget (see `infra/README.md` follow-ups).
- Archive this runbook with the dates and names filled in.
