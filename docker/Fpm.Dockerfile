FROM php:7.4-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql \
&& apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/* \
&& printf "\n" | pecl install imagick \
&& docker-php-ext-enable imagick