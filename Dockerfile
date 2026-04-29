FROM php:8.2-apache

# Cài đặt các extension PHP cần thiết cho database
RUN docker-php-ext-install pdo pdo_mysql

# Kích hoạt Apache mod_rewrite để hỗ trợ routing (nếu dùng .htaccess)
RUN a2enmod rewrite

# Cấp quyền cho thư mục web
RUN chown -R www-data:www-data /var/www/html
