FROM php:7.4-apache

# import apache global configuration
RUN rm /etc/apache2/sites-available/000-default.conf
ADD ./docker/config/000-default.conf /etc/apache2/sites-available/000-default.conf

# import apache sites
RUN rm /etc/apache2/apache2.conf
ADD ./docker/config/apache2.conf /etc/apache2/apache2.conf


# enable mods
RUN a2enmod rewrite

# import php.ini configs
RUN rm /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini-development
ADD ./docker/config/php/php.ini-production /usr/local/etc/php/php.ini-production
ADD ./docker/config/php/php.ini-development /usr/local/etc/php/php.ini-development

# restart the apache service
RUN service apache2 restart

# update repo-lists
RUN apt update

# install needed non-php packages
RUN apt install -y wget curl unzip supervisor


# import background workers
RUN rm /etc/supervisor/conf.d -r && mkdir -p /var/log/core/
ADD ./docker/supervisor/conf.d /etc/supervisor/conf.d

# install gd packages
RUN apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# install core pecl packages
RUN apt-get install -y zlib1g-dev
RUN pecl install redis
RUN docker-php-ext-enable redis

# install postgres packages
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# install ext and ext-zip packages
RUN apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# copy and install packages
WORKDIR /var/www/html/
COPY ./ ./
RUN composer install
RUN chown -R www-data:www-data /var/www/html

# install npm packages
# RUN apt-get install -y gnupg2
# RUN rm -rf /var/lib/apt/lists/ && curl -sL https://deb.nodesource.com/setup_15.x | bash -
# RUN apt-get install nodejs -y
# RUN npm i
# RUN npm i -g laravel-echo-server

CMD ["/var/www/html/install.sh"]
