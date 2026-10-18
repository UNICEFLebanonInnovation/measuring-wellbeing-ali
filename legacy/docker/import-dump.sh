#!/usr/bin/env bash
# Import a MySQL dump (for example the production export from GoDaddy)
# into the legacy reference database.
#
#   ./docker/import-dump.sh ../path/to/dump.sql
#
set -euo pipefail

DUMP="${1:-}"
if [[ -z "$DUMP" || ! -f "$DUMP" ]]; then
  echo "usage: $0 <dump.sql>" >&2
  exit 1
fi

cd "$(dirname "$0")/.."

echo "Importing $DUMP into legacy-db (database sdq)..."
docker compose exec -T legacy-db sh -c 'mysql -uroot -proot sdq' < "$DUMP"

echo "Tables now present:"
docker compose exec -T legacy-db sh -c 'mysql -uroot -proot -N -e "SELECT table_name, table_rows FROM information_schema.tables WHERE table_schema=\"sdq\" ORDER BY table_name"'

echo "Clearing Laravel caches..."
docker compose exec -T legacy-app sh -c 'php artisan config:clear && php artisan cache:clear && php artisan view:clear' || true
echo "Done. Open http://localhost:8081"
