# Use the official PHP image from the Docker Hub
FROM php:8.3-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
libzip-dev \
unzip \
&& docker-php-ext-install pdo pdo_mysql mysqli zip

# Enable Apache mod_rewrite for SEO-friendly URLs
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the application source code to the container
COPY . /var/www/html/

# Ensure permissions are correct
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]