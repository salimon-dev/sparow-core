#!/bin/sh
php artisan migrate:fresh --seed
php artisan passport:install --force
php artisan serve
