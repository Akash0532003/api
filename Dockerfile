# Use official PHP + Apache image
FROM php:8.1-apache

# Copy your PHP project into the web root
COPY . /var/www/html/

# (Optional) Enable Apache mod_rewrite if needed
RUN a2enmod rewrite

# Set proper permissions (if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
