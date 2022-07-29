#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#

ARG PHP_VERSION
FROM php:${PHP_VERSION}-alpine

# Start as root
USER root

RUN apk add --no-cache autoconf zlib-dev libzip-dev && \
    docker-php-ext-install opcache zip sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

ENV APP_ENV=prod

RUN composer install --no-dev --no-scripts --prefer-dist --no-progress --no-interaction

RUN ./vendor/bin/rr get-binary --location /usr/local/bin

RUN composer dump-autoload --optimize && \
    composer check-platform-reqs && \
    php bin/console cache:warmup

EXPOSE 8080

CMD ["rr", "serve"]
