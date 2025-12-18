FROM php:8.5-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        curl \
        libzip-dev \
        libpq-dev \
        libpng-dev \
        unzip \
        gdal-bin \
        libgdal-dev \
        && docker-php-ext-install gd zip pgsql pdo_pgsql

COPY ./docker/prod/api/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN echo "upload_max_filesize=200M\npost_max_size=200M" > /usr/local/etc/php/conf.d/uploads.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
