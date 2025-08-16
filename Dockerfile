# Stage 0: Build Laravel app
FROM php:8.2-apache AS laravel-app

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring bcmath zip gd exif pcntl \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --optimize-autoloader --ignore-platform-reqs

# Copy the rest of the application
COPY . .

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Clear caches (safe)
RUN php artisan config:clear || true && \
    php artisan cache:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
