# Use the official PHP image from the Docker Hub
FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Composer to install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Install any required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80
EXPOSE 80
