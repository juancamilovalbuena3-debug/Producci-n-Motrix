#!/usr/bin/env bash
set -o errexit

echo "Instalando dependencias..."
composer install --no-dev --optimize-autoloader

echo "Optimizando Laravel para produccion..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Ejecutando migraciones..."
php artisan migrate --force
