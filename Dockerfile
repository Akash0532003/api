FROM php:8.1-apache

# Enable mysqli
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy app code
COPY . /var/www/html/

# Set ownership (optional, improves permission handling)
RUN chown -R www-data:www-data /var/www/html
