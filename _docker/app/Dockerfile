FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      libmagickwand-dev \
      git && \
      pecl install imagick && \
      docker-php-ext-enable imagick && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini


COPY app                /var/www/app
COPY bootstrap          /var/www/bootstrap
COPY config             /var/www/config
COPY database           /var/www/database
COPY public             /var/www/public
COPY resources          /var/www/resources
COPY artisan            /var/www/artisan
COPY routes             /var/www/routes
COPY storage            /var/www/storage
COPY package.json       /var/www/package.json
COPY package-lock.json  /var/www/package-lock.json
COPY postcss.config.js  /var/www/postcss.config.js
COPY vite.config.js     /var/www/vite.config.js
COPY tailwind.config.js /var/www/tailwind.config.js
COPY tsconfig.json      /var/www/tsconfig.json

COPY composer.*  ./

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

RUN npm install

WORKDIR /var/www/phoenix-cinema.live
