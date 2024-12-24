# Use the official PHP image from the Docker Hub
FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . .

# Install any required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 80
EXPOSE 80
