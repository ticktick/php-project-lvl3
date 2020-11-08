FROM php:7.4

RUN apt-get update
RUN apt-get install -y libpq-dev libzip-dev unzip
RUN docker-php-ext-install pdo_pgsql zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /app