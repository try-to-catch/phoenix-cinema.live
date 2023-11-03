FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
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
COPY routes             /var/www/routes
COPY storage            /var/www/storage
COPY artisan            /var/www/artisan
COPY package.json       /var/www/package.json
COPY vite.config.js     /var/www/vite.config.js
COPY tailwind.config.js /var/www/tailwind.config.js
COPY tsconfig.json      /var/www/tsconfig.json

COPY composer.*  ./

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
# alias
RUN echo "alias a='artisan'" >> /root/.bashrc

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

RUN npm install

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /usr/src/php/ext/imagick; \
    curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1; \
    docker-php-ext-install imagick;

RUN composer install
RUN php artisan migrate

RUN composer dump-autoload  --no-scripts --optimize && \
    chown -R root:www-data /var/www && \
    chmod 755 -R /var/www && \
    chmod -R 777 /var/www/storage && \
    chmod -R 775 /var/www/bootstrap/cache


WORKDIR /var/www/phoenix-cinema.live
