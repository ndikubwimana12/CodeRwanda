# Use official PHP + Apache image
FROM php:8.2-apache

# Install mysqli and PDO MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copy all project files into Apache web root
COPY . /var/www/html/

# Set correct permissions
RUN chmod -R 755 /var/www/html && \
    chown -R www-data:www-data /var/www/html

# Enable Apache rewrite module (optional but useful)
RUN a2enmod rewrite

# Expose port 80 (default for Apache)
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
