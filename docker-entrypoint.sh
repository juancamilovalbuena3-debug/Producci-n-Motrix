#!/bin/bash
set -e

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan session:table 2>/dev/null || true
php artisan migrate --force

apache2-foreground
