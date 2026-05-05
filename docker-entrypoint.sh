#!/bin/bash
set -e

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Mostrar logs de Laravel en stdout
touch /var/www/html/storage/logs/laravel.log
tail -f /var/www/html/storage/logs/laravel.log &

apache2-foreground
