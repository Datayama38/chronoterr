FROM registry.forge.inrae.fr/lessem/mappatous/base-api:latest

COPY ./api /var/www/html/

COPY ./api/.env.prod /var/www/html/.env

RUN composer update

RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/public/img \
        /var/www/html/bootstrap/cache

RUN php artisan key:generate

RUN a2enmod rewrite

RUN service apache2 restart