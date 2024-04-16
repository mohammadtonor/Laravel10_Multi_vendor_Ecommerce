FROM php:8.1.0-apache
WORKDIR /var/www/html

# Mod Rewrite
# Linux Library
RUN apt-get update -y && apt-get install -y\ 
libicu-dev \
libmariadb-dev \
unzip zip \
zlib1g-dev \
libpng-dev \
libjpeg-dev \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
curl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html /var/www/html/storage /var/www/html/bootstrap/cache

  
RUN composer install --no-dev --optimize-autoloader
EXPOSE 80
# CMD ["/start.sh"]
