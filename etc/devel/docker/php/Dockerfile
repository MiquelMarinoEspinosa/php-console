FROM php:7-cli-alpine

RUN apk add --no-cache --update --virtual buildDeps autoconf && apk add --no-cache alpine-sdk && apk add --no-cache yaml-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN pecl install redis && docker-php-ext-enable redis
RUN pecl channel-update pecl.php.net
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d
RUN mkdir -p /app
RUN composer global require hirak/prestissimo

WORKDIR /app