#!/bin/sh

# Replace ${PORT} in nginx template and output to Alpine's default site config
envsubst '${PORT}' < /var/www/html/docker/nginx.conf.template > /etc/nginx/http.d/default.conf

# Clear and Cache Laravel configurations for production performance
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"
