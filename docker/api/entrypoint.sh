#!/bin/bash

set -e

# localではmigrateのみ
# php aritsan migrate

php artisan migrate

php-fpm

exec "$@"
