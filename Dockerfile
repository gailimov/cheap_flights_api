FROM php:7.4.3-alpine3.11

RUN apk add -U \
        postgresql-dev \
    && docker-php-ext-install \
        pdo_pgsql

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:1.9.3 /usr/bin/composer /usr/bin/composer

COPY . /app
WORKDIR /app

CMD composer install \
    && php -S 0.0.0.0:8080 -t /app/public
