FROM php:8.0.24-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

RUN apk update
RUN apk --no-cache add curl pcre-dev ${PHPIZE_DEPS}
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apk add --upgrade php8-pear
RUN pecl install mongodb
RUN docker-php-ext-enable mongodb
RUN apk del pcre-dev ${PHPIZE_DEPS}

ENTRYPOINT [ "./run.sh" ]