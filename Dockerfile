# Use official PHP with Apache
FROM php:8.1-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy composer files first (for better build caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (ignore scripts during build)
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress --no-interaction

# Copy the entire application
COPY . .

# Run post-autoload scripts AFTER copying full code (fixes artisan errors)
RUN composer dump-autoload --optimize && \
    composer run-script post-autoload-dump || true

# Clear Laravel caches
RUN php artisan config:clear || true && \
    php artisan cache:clear || true && \
    php artisan route:clear || true && \
    php artisan view:clear || true

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Run migrations, then start Apache
CMD php artisan migrate --force || true && apache2-foreground
