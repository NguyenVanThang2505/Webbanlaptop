FROM php:8.1-apache

# Bật mod_rewrite cho Apache
RUN a2enmod rewrite

# Copy code vào thư mục Apache
COPY . /var/www/html/

# Bật AllowOverride cho .htaccess hoạt động
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

EXPOSE 80
