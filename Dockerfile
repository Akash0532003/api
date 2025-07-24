# Use official PHP + Apache image
FROM php:8.1-apache

# Copy your PHP project into the web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional)
RUN a2enmod rewrite

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80
