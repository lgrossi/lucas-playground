FROM php:8.0.2-fpm

WORKDIR /srv/

COPY . ./

# Install git
RUN apt-get update && apt-get install -y git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install pcntl
RUN docker-php-ext-install pcntl

# Execute composer
RUN composer install && composer dump

ENTRYPOINT ["vendor/bin/parable", "server", "--public='public'", "--port=8080", "--host='0.0.0.0'"]
