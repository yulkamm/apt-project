FROM php:8.2-apache

# Установка расширений PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Включение mod_rewrite для Apache
RUN a2enmod rewrite

# Установка прав
RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80
EXPOSE 80

# Запуск Apache
CMD ["apache2-foreground"]
