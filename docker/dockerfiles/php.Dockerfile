FROM php:8.3-fpm

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql