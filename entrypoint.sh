#!/usr/bin/env bash
chown -R www-data /var/www/html
php artisan migrate --seed 
php-fpm &
service nginx start &
tail -f /var/log/nginx/*log
