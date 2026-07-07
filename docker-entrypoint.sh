#!/bin/sh
set -e

# Cache configuration, routes, and views for speed in production
if [ "${APP_ENV}" = "production" ]; then
    echo "Caching configuration and routes for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Run database migrations (optional, based on RUN_MIGRATIONS environment variable)
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Execute the main command
exec docker-php-entrypoint "$@"
