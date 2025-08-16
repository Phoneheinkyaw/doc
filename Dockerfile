# Use official PHP + Apache image
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (for caching)
COPY composer.json composer.lock ./

# Install Composer binary
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Install dependencies WITHOUT running artisan scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Now copy the whole Laravel project
COPY . .

# Run composer scripts AFTER project files are present
RUN composer dump-autoload --optimize && \
    composer run-script post-autoload-dump || true

# Cache Laravel configs
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache || true

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
