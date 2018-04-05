FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libpq-dev git curl zip \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

WORKDIR /code
