FROM php:8.0.2-fpm

RUN apt-get update && apt-get install -y git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pcntl

WORKDIR /srv/

COPY . ./

RUN composer install

RUN composer dump

WORKDIR public

ENTRYPOINT ["php", "-S", "0.0.0.0:8080"]
