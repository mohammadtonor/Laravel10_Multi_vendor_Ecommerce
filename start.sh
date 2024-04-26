#!/usr/bin/env bash
echo "Running composer"
composer dump-autoload
composer update --no-scripts

echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

