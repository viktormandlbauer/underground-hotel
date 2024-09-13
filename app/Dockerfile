# Use the official PHP image with Apache
FROM php:8.3-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy the application code to the Apache document root
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Expose the default Apache port
EXPOSE 80