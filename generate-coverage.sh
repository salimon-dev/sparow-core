#!/bin/sh
php artisan migrate:fresh --seed
php artisan passport:install --force
vendor/bin/phpunit --coverage-html reports/
