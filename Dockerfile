# Use official PHP 8.2 image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Install PHP dependencies without running artisan scripts yet
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-interaction

# Copy the full Laravel project
COPY . .

# Run post-autoload scripts safely after full project is present
RUN composer run-script post-autoload-dump || true

# Clear Laravel caches safely
RUN php artisan config:clear || true && \
    php artisan cache:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# Set permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Run migrations automatically and start Apache
CMD php artisan migrate --force || true && apache2-foreground
