FROM php:8.2-apache

# Установка расширений PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# КРИТИЧЕСКИ ВАЖНО: Отключаем ВСЕ MPM перед включением
RUN a2dismod mpm_event || true && \
    a2dismod mpm_worker || true && \
    a2enmod mpm_prefork && \
    a2enmod rewrite headers

# Копирование исходного кода
COPY src/ /var/www/html/

# Настройка прав
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
