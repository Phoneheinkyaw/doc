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

# Copy composer binary
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy only composer files first (for caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Now copy the whole Laravel project
COPY . .

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Apache port
EXPOSE 80

# Start Apache (don’t run artisan here, safer to run manually on Render)
CMD ["apache2-foreground"]
