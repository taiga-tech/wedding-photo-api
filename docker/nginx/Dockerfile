FROM nginx:latest

RUN apt-get update \
    && apt-get install -y apt-utils \
    locales \
    && sed -i -e 's/# ja_JP.UTF-8/ja_JP.UTF-8/g' /etc/locale.gen \
    && locale-gen ja_JP.UTF-8
ENV LANG ja_JP.UTF-8
ENV LC_TIME C

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/

COPY ./src/public /var/www/public
RUN chown -R www-data:www-data /var/www
