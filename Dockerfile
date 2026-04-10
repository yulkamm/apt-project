FROM php:8.2-fpm

# Установка расширений PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Установка Nginx
RUN apt-get update && apt-get install -y nginx

# Копирование исходного кода
COPY src/ /var/www/html/

# Настройка Nginx
COPY nginx.conf /etc/nginx/sites-available/default

# Настройка прав
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Порт для Railway
EXPOSE 80

# Запуск Nginx и PHP-FPM
CMD service php8.2-fpm start && \
    nginx -g 'daemon off;'
