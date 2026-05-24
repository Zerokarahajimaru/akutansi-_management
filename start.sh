#!/bin/sh

# Replace ${PORT} in nginx template and output to default site config
envsubst '${PORT}' < /var/www/html/docker/nginx.conf.template > /etc/nginx/sites-available/default

# Re-link for safety
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Clear and Cache Laravel configurations for production performance
php artisan optimize:clear
php artisan optimize
php artisan view:cache
php artisan event:cache

# Start PHP-FPM in the background
php-fpm -D

# Start Nginx in the foreground
nginx -g "daemon off;"
