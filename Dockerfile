# Use official PHP + Apache image
FROM php:8.2-apache

# Install mysqli and PDO MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

# Copy all project files into Apache web root
COPY . /var/www/html/

# Set correct permissions for Apache
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Enable Apache rewrite module (optional but often needed)
RUN a2enmod rewrite

# Optional: allow .htaccess to work properly
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Expose port 80 (default for Apache)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
