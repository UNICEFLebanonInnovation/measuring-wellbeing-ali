# Legacy application (Laravel 5.8) - reference environment

This folder is the original Measuring Well-Being application exactly as it was deployed on GoDaddy. It is kept so that:

1. The production database export can be loaded and inspected in a known-good environment.
2. Scores, dashboards, reports and the CSV export of the **new** application can be compared against this one before cutover.
3. The current Android APK can still be pointed at it during testing.

Do not develop new features here. The modernised application lives at the repository root.

## Running it

```bash
cd legacy
cp .env.example .env
docker compose up -d --build
# generate an application key once the container is up
docker compose exec legacy-app php artisan key:generate
# load the production export (or one of the 2020 dev dumps under database/Backup)
./docker/import-dump.sh ../path/to/production_dump.sql
```

Open http://localhost:8081. Mail sent by the app is captured by Mailpit at http://localhost:8026.

## Known characteristics (see docs/SYSTEM_REVIEW_REPORT.md)

- The migrations in `database/migrations` do **not** describe the production schema. Columns such as `collectors.prefix`, the `*_scale` columns on `application_value`, `reason_option` / `reason_details` on `application`, `users.api_token` and the `application_log` table were added directly on the server. Always start from a production dump, never from `php artisan migrate`.
- `vendor/` is committed, so no `composer install` is needed for PHP 7.4.
- The SQL dumps under `database/Backup` are development data from December 2019 to January 2020, not production data.
