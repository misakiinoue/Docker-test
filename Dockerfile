FROM php:8.1-fpm-alpine AS php

RUN docker-php-ext-install pdo_mysql
RUN install -o www-data -g www-data -d /var/www/upload/image/
