FROM php:8.2-fpm

# Установка зависимостей и расширений
RUN apt-get update && apt-get install -y \
    nginx \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Копирование исходного кода
COPY src/ /var/www/html/

# Копирование конфигураций
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Настройка прав
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p /run/php \
    && chown www-data:www-data /run/php

# Порт
EXPOSE 80

# Скрипт запуска
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["docker-entrypoint.sh"]
