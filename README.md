# Measuring Well-Being (SDQ) platform

Web platform and API used by UNICEF Lebanon and child-protection partners to run the Strengths and Difficulties Questionnaire (SDQ) as a pre-test and post-test around focused psychosocial support, and to report the share of children whose well-being improved.

This repository holds the **modernised application** (Laravel 13, PHP 8.3, Inertia + Vue 3, Docker, Azure) and, under `legacy/`, the original Laravel 5.8 application kept as a reference environment for the migration.

## Repository layout

| Path | What |
|---|---|
| `/` (root) | The new application: Laravel 13 app, `Dockerfile`, `docker-compose.yml`, tests |
| `app/Sdq/` | Domain: scoring, workflow (`ApplicationService`), code generation, statuses, form options |
| `app/Http/Controllers/Api/` | API v1 (Sanctum) and the legacy-compatible API for the existing Android app |
| `resources/js/` | Vue 3 pages and layouts (English/Arabic, RTL) |
| `database/migrations/0000_*` | Baseline (legacy-compatible) and modernise migrations, safe on a restored production dump |
| `legacy/` | Original Laravel 5.8 app + Docker reference environment (`legacy/README.md`) |
| `infra/` | Azure Bicep templates and deployment guide |
| `.github/workflows/` | CI (tests, build, image), Deploy (ACR + Container Apps), Infrastructure (Bicep) |
| `docs/` | Review report, architecture, migration runbook, operations, retained project documents |

## Quick start (local)

With Docker:

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed       # roles, statuses, Lebanon locations
# create the first admin
docker compose exec -e SDQ_ADMIN_EMAIL=admin@example.org -e SDQ_ADMIN_PASSWORD='ChangeMe123' app \
  php artisan db:seed --class=AdminUserSeeder
npm install && npm run dev                                 # Vite on the host
open http://localhost:8000                                 # Mailpit: http://localhost:8025
```

Without Docker (PHP 8.3, Composer, Node 22; SQLite):

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env && touch database/database.sqlite
php artisan migrate --seed
composer run dev            # serves app + queue + vite
```

## Tests and checks

```bash
php artisan test            # unit + feature (SQLite in memory)
vendor/bin/pint --test      # code style
npm run build               # front-end build
docker build -t measuring-wellbeing .
```

## Deployment

- Image: multi-stage `Dockerfile` (Composer, Vite, FrankenPHP). One image, `CONTAINER_ROLE` = `web` | `worker` | `scheduler` | `migrate`.
- Azure: `infra/main.bicep` provisions Container Apps, MySQL Flexible Server, Key Vault, Storage, ACR and monitoring. Commands and GitHub OIDC setup in [`infra/README.md`](infra/README.md).
- Pipelines: `ci.yml` on every push/PR; `deploy.yml` builds and pushes the image, runs the migrate job, updates the apps (`main` to staging automatically, production behind an approval); `infra.yml` deploys Bicep with a what-if step.
- Cutover procedure: [`docs/MIGRATION_RUNBOOK.md`](docs/MIGRATION_RUNBOOK.md). Day-2: [`docs/OPERATIONS.md`](docs/OPERATIONS.md).

## Status

| Area | State | Notes |
|---|---|---|
| Domain model, migrations, seeders | Done | Legacy-compatible schema; additive modernise migration; locations with legacy ids |
| Scoring and workflow service | Done | Documented and legacy scoring policies; NA, dropout, consent, quota; tests |
| Web UI (Inertia/Vue, EN/AR) | Done | Auth, dashboard, applications, tests forms, partners, collectors, admins, statuses, locations, change-decrease, CSV export |
| Analytics and reports | Done | Report service and chart pages replacing the legacy ReportController |
| API v1 (Sanctum, sync) | Done | `/api/v1`, idempotent `client_uuid`, contract in `docs/API.md` |
| Legacy API for current Android APK | Done | Same paths and payloads as the old app, routed to the shared workflow service |
| Docker + local compose | Done | FrankenPHP image, MySQL 8.4, Mailpit |
| Azure infrastructure (Bicep) | Done | Compiles; first deployment pending an Azure subscription |
| CI/CD (GitHub Actions) | Done | Needs OIDC app registration and repository secrets/variables |
| Documentation | Done | Architecture, runbook, operations, API |
| New mobile app | Pending | Offline-first client of `/api/v1`; old APK keeps working meanwhile |
| Azure Blob Storage for logos/exports | Pending | Storage account provisioned; Laravel adapter and `FILESYSTEM_DISK` switch to do |
| Microsoft Entra ID sign-in for admins | Pending | Decision needed |
| Scoring policy decision | Pending | `documented` by default; see `docs/ARCHITECTURE.md` section 7 |
| Production data export and verification | Pending | Needs the GoDaddy dump; see runbook steps 1 to 4 |

## Documentation

- [System review and migration assessment](docs/SYSTEM_REVIEW_REPORT.md)
- [Architecture](docs/ARCHITECTURE.md)
- [Migration runbook](docs/MIGRATION_RUNBOOK.md)
- [Operations](docs/OPERATIONS.md)
- [API contract](docs/API.md)
- [Azure infrastructure](infra/README.md)
- [Retained project documents](docs/README.md)
