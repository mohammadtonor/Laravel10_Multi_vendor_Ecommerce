#!/usr/bin/env bash
echo "Running composer"
cp /etc/secrets/.env .env

echo "Clearing caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Running migrations..."
php artisan migrate --force

echo "done deploying"