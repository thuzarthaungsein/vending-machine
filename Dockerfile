# Use the official PHP image from the Docker Hub
FROM php:8.3-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Set the working directory
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
