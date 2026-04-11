#!/bin/bash
set -e

# Запуск PHP-FPM в фоне
php-fpm8.2 &

# Запуск Nginx в фоне (не daemon)
nginx -g 'daemon off;'
