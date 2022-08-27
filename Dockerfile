# docker build -f Dockerfile . --network=host -t storaji:1.0.0
# docker run --network="host" storaji:1.0.0

FROM php:7-alpine3.16

RUN apk --update add wget curl

RUN docker-php-ext-install pdo_mysql

RUN apk add graphicsmagick

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer --version=1.8.0 

RUN mkdir -p /var/www

COPY . /var/www

WORKDIR /var/www

RUN composer install

RUN php artisan key:generate

RUN php artisan migrate

RUN php artisan passport:install

CMD php artisan serve

