FROM php:8.2-fpm-alpine3.19

RUN apk update

RUN php -r "copy('https://getcomposer.org/download/2.7.1/composer.phar', 'composer.phar');"
RUN php -r "if (hash_file('sha256', 'composer.phar') === '1ffd0be3f27e237b1ae47f9e8f29f96ac7f50a0bd9eef4f88cdbe94dd04bfff0') { echo 'Composer verified'; } else { echo 'Composer corrupt'; unlink('composer.phar'); } echo PHP_EOL;"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install opcache
RUN apk add autoconf g++ make && \
    apk add linux-headers && \
    pecl install -f xdebug && \
    docker-php-ext-enable xdebug && \
    apk del --purge autoconf g++ make

# Copy the php config file
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN chmod 0655 /usr/local/etc/php/conf.d/*
RUN chmod -x /usr/local/etc/php/conf.d/*

# Copy the application code
#COPY . /app

VOLUME ["/app"]
WORKDIR /app