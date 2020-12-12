#!/bin/sh

# supervisor
service supervisor start
# database
php artisan migrate --seed
php artisan passport:install --uuids -n --force
# http server
/usr/sbin/apache2ctl -D FOREGROUND
