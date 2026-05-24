# Step 1: Base Image
FROM php:8.2-fpm-alpine

# Step 2: Install dependencies
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libzip-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    gettext \
    nodejs \
    npm \
    git \
    curl

# Step 3: Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_pgsql pdo_mysql zip bcmath

# Step 4: Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 5: Set working directory
WORKDIR /var/www/html

# Step 6: Copy project files
COPY . .

# Step 7: Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Step 8: Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Step 9: Prepare Start Script
RUN chmod +x /var/www/html/start.sh

# Step 10: Final Setup
EXPOSE 80
ENTRYPOINT ["/var/www/html/start.sh"]
