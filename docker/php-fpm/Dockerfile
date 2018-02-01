# BEGINNING OF THE COMMON PART

FROM php:7.0-fpm

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash - \
    && apt-get update \
    && apt-get install -y \
        git \
        libicu-dev \
        zlib1g-dev \
        libxrender1 \
        libfontconfig \
        curl \
        wget \
        zip \
        libcurl4-gnutls-dev \
        libxml2-dev \
        netcat \
    && rm -rf /var/lib/apt/lists/*

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && composer global require "hirak/prestissimo:^0.3" \
    && curl -L -o /usr/local/bin/docker-php-pecl-install https://raw.githubusercontent.com/helderco/docker-php/master/template/bin/docker-php-pecl-install \
    && chmod +x /usr/local/bin/docker-php-pecl-install

RUN docker-php-pecl-install APCu-5.1.5 \
    && docker-php-ext-enable apcu

RUN docker-php-pecl-install xdebug-2.5.5

RUN docker-php-ext-install -j$(nproc) \
    curl \
    mbstring \
    pdo \
    pdo_mysql \
    bcmath \
    zip


RUN docker-php-ext-install -j$(nproc) \
    intl \
    mysqli

RUN usermod -u 1000 www-data
RUN chown www-data:www-data -R /var/www

USER www-data

WORKDIR /var/www
