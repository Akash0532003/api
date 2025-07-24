FROM php:8.1-apache

# Copy all your code into the Apache web root
COPY . /var/www/html/

# Give Apache permission to read/write if needed
RUN chown -R www-data:www-data /var/www/html

# Enable Apache mod_rewrite (optional, but common)
RUN a2enmod rewrite

EXPOSE 80
