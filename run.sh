#!/bin/sh

composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction
php artisan migrate
php -S 0.0.0.0:9000 -t public