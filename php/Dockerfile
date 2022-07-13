ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine
WORKDIR /var/www/html
LABEL Maintainer="thomas.chen" Version="2021.12" Description="PHP 7.2 Dev镜像"

#阿里云源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories
RUN apk add --no-cache autoconf g++ libtool make curl-dev libxml2-dev linux-headers libzip-dev

RUN docker-php-ext-install bcmath pcntl pdo_mysql mysqli curl zip

#Composer
RUN set -x; \
    wget https://mirrors.aliyun.com/composer/composer.phar; \
    chmod u+x composer.phar; \
    mv composer.phar /usr/local/bin/composer; \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

#GD扩展
RUN apk add --no-cache freetype-dev libjpeg-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install ${MC} gd

#SWOOLE扩展
ARG PHP_SWOOLE=false
RUN if [ ${PHP_SWOOLE} != false ]; then \
    curl -O http://pecl.php.net/get/swoole-${PHP_SWOOLE}.tgz -L \
    && pecl install swoole-${PHP_SWOOLE}.tgz \
    && docker-php-ext-enable swoole \
;fi

#REDIS扩展
ARG PHP_REDIS=false
RUN if [ ${PHP_REDIS} != false ]; then \
    curl -O http://pecl.php.net/get/redis-${PHP_REDIS}.tgz -L \
    && pecl install redis-${PHP_REDIS}.tgz \
    && docker-php-ext-enable redis \
;fi

#RDKAFKA依赖-librdkafka
ARG LIB_RDKAFKA=false
RUN if [ ${LIB_RDKAFKA} != false ]; then \
    wget https://github.com/edenhill/librdkafka/archive/v${LIB_RDKAFKA}.tar.gz -O /tmp/libkafka.tar.gz \
    && mkdir -p /tmp/libkafka \
    && tar -xf /tmp/libkafka.tar.gz -C /tmp/libkafka --strip-components=1 \
    && rm /tmp/libkafka.tar.gz \
        && ( \
            cd /tmp/libkafka \
            && ./configure  \
            && make -j$(nproc) \
            && make install \
        ) \
    && rm -r /tmp/libkafka \
;fi

#RDKAFKA扩展
ARG PHP_RDKAFKA=false
RUN if [ ${PHP_RDKAFKA} != false ]; then \
    curl -O http://pecl.php.net/get/rdkafka-${PHP_RDKAFKA}.tgz -L \
    && pecl install rdkafka-${PHP_RDKAFKA}.tgz \
    && docker-php-ext-enable rdkafka \
;fi

#AMQP依赖-librabbitmq
ARG LIB_RABBITMQ=false
RUN if [ ${LIB_RABBITMQ} != false ]; then \
    wget https://github.com/alanxz/rabbitmq-c/releases/download/v${LIB_RABBITMQ}/rabbitmq-c-${LIB_RABBITMQ}.tar.gz -O /tmp/librabbitmq.tar.gz \
    && mkdir -p /tmp/librabbitmq \
    && tar -xf /tmp/librabbitmq.tar.gz -C /tmp/librabbitmq --strip-components=1 \
    && rm /tmp/librabbitmq.tar.gz \
        && ( \
            cd /tmp/librabbitmq \
            && ./configure  \
            && make -j$(nproc) \
            && make install \
        ) \
    && rm -r /tmp/librabbitmq \
;fi

#PDO_SQLSRV
ARG PHP_SQLSRV=false
RUN if [ ${PHP_SQLSRV} != false ]; then \
    pecl install pdo_sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv \
;fi

#AMQP扩展
ARG PHP_AMQP=false
RUN if [ ${PHP_AMQP} != false ]; then \
    curl -O http://pecl.php.net/get/amqp-${PHP_AMQP}.tgz -L \
    && pecl install amqp-${PHP_AMQP}.tgz \
    && docker-php-ext-enable amqp \
;fi

#XDEBUG
# ARG PHP_XDEBUG=false
# RUN if [ ${PHP_XDEBUG} != false ]; then \
#     pecl install xdebug \
#     && docker-php-ext-enable xdebug \
# ;fi
