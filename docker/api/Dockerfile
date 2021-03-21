FROM php:7.4-fpm-buster

COPY ./docker/api/php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y zlib1g-dev libpng-dev libzip-dev libjpeg-dev libfreetype6-dev \
    && apt-get install -y unzip mariadb-client vim \
    && docker-php-ext-install zip pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Node.js install
RUN curl -sL https://deb.nodesource.com/setup_15.x | bash -
RUN apt-get install -y nodejs

# yarn install
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ENV COMPOSER_HOME /composer

ENV PATH $PATH:/composer/vendor/bin

COPY ./docker/api/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.6.0/wait /wait
RUN chmod +x /wait

WORKDIR /var/www
COPY ./src /var/www
RUN chown -R www-data:www-data /var/www

RUN composer global require "laravel/installer"

RUN echo 'alias ar="php artisan"' >> ~/.bashrc \
    && echo 'alias watch="npm run watch-poll"' >> ~/.bashrc

# CMD /wait && /usr/local/bin/entrypoint.sh
