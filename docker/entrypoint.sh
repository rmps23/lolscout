#!/bin/sh
set -e

# Hosts tell the container which port to listen on.
sed -ri "s/Listen 80/Listen ${PORT:-8080}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-8080}>/" /etc/apache2/sites-available/000-default.conf

if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is not set. Generate one with: php artisan key:generate --show" >&2
  exit 1
fi

php artisan storage:link --force >/dev/null 2>&1 || true
php artisan migrate --force --no-interaction

# Reference data (roles, nations, ranks) is idempotent; demo data only in showcase mode.
php artisan db:seed --class=LookupSeeder --force --no-interaction
if [ "$APP_SHOWCASE" = "true" ]; then
  php artisan db:seed --class=DemoSeeder --force --no-interaction
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
