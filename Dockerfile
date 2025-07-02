# Use official WordPress image
FROM wordpress:6.8-php8.2-apache

# Copy custom themes or plugins if you want
COPY wp-content /var/www/html/wp-content
COPY wp-admin /var/www/html/wp-admin
COPY wp-includes /var/www/html/wp-includes

# Change PHP settings if needed
# COPY custom-php.ini /usr/local/etc/php/conf.d/

# Expose port (default already)
EXPOSE 80