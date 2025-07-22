FROM php:8.1-apache

# Copy toàn bộ mã nguồn vào thư mục web
COPY . /var/www/html/

# Mở cổng 80 (cổng web mặc định)
EXPOSE 80
