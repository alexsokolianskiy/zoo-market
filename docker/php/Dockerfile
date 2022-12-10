FROM php:8.1.6-fpm

RUN apt-get update -y && apt-get install -y libpng-dev libzip-dev gcc g++ libtool libmcrypt-dev libpq-dev zlib1g-dev unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath gd zip

# Composer install
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# Xdebug install
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

ARG uname
ARG gid
ARG uid

# Create system user to run Composer and Artisan Commands
RUN groupadd --gid $gid $uname
RUN useradd -G www-data,root -s /bin/bash --uid $uid --gid $gid $uname

WORKDIR /var/www/html/

USER $uname