# Use the official PHP image with Apache
FROM php:7.4-apache

# Install necessary extensions
RUN docker-php-ext-install mysqli

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application files
COPY . /var/www/html/

# Install PHP dependencies
RUN composer install --no-dev

# Expose port 80
EXPOSE 80
