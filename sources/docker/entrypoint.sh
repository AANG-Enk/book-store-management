#!/usr/bin/env sh
set -e

cd /var/www/html

# Ensure writable Laravel runtime folders exist after volume mounts.
# mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache

# Clear stale cached config/routes/views from local development.
php artisan optimize:clear >/dev/null 2>&1 || true

# Optional automatic migration. Keep true for simple student deployment.
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
  echo "Waiting for database..."
  ATTEMPTS=0
  until php artisan migrate:status >/dev/null 2>&1; do
    ATTEMPTS=$((ATTEMPTS+1))
    if [ "$ATTEMPTS" -ge 30 ]; then
      echo "Database is not ready after 30 attempts. Continuing without migration status check."
      break
    fi
    sleep 2
  done

  php artisan migrate --force

  if [ "${RUN_SEEDERS:-false}" = "true" ]; then
    php artisan db:seed --force
  fi
fi

php artisan storage:link >/dev/null 2>&1 || true
php artisan config:cache >/dev/null 2>&1 || true
php artisan route:cache >/dev/null 2>&1 || true
php artisan view:cache >/dev/null 2>&1 || true

exec "$@"
