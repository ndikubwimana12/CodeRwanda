# Use the official PHP + Apache image
FROM php:8.2-apache

# Copy all project files into Apache's document root
COPY . /var/www/html/

# Set correct file permissions
RUN chmod -R 755 /var/www/html && \
    chown -R www-data:www-data /var/www/html

# Enable Apache rewrite module (for clean URLs, if needed)
RUN a2enmod rewrite

# Expose port 80 (Render expects this)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
