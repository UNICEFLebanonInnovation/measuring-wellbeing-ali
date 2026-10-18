#!/usr/bin/env bash
# Container entrypoint. CONTAINER_ROLE selects what this replica does:
#   web       - serve HTTP (default)
#   worker    - run the queue worker
#   scheduler - run the scheduler loop
#   migrate   - run migrations and seed reference data, then exit
set -euo pipefail

cd /app

role="${CONTAINER_ROLE:-web}"

if [[ -z "${APP_KEY:-}" ]]; then
  echo "APP_KEY is not set" >&2
  exit 1
fi

# Cache framework configuration for this process (env already injected).
php artisan config:cache --no-ansi >/dev/null
php artisan route:cache --no-ansi >/dev/null
php artisan view:cache --no-ansi >/dev/null
php artisan event:cache --no-ansi >/dev/null

case "$role" in
  web)
    if [[ "${RUN_MIGRATIONS_ON_START:-false}" == "true" ]]; then
      php artisan migrate --force --no-ansi
    fi
    php artisan storage:link --force --no-ansi >/dev/null 2>&1 || true
    exec frankenphp run --config /etc/caddy/Caddyfile
    ;;
  worker)
    exec php artisan queue:work --tries=3 --max-time=3600 --sleep=3 --no-ansi
    ;;
  scheduler)
    exec php artisan schedule:work --no-ansi
    ;;
  migrate)
    php artisan migrate --force --no-ansi
    php artisan db:seed --force --no-ansi --class=RoleSeeder
    php artisan db:seed --force --no-ansi --class=StatusSeeder
    php artisan db:seed --force --no-ansi --class=LocationSeeder
    php artisan db:seed --force --no-ansi --class=AdminUserSeeder
    ;;
  *)
    exec "$@"
    ;;
esac
