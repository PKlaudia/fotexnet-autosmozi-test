#!/bin/sh

echo "Migrating the database..."
php artisan migrate --force

echo "Seeding the database..."
php artisan db:seed --force

echo "Generating API documentation..."
php artisan l5-swagger:generate

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8000
