FROM php:8.1.0-apache

# Mod Rewrite
RUN a2enmod rewrite

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

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html /var/www/html/storage /var/www/html/bootstrap/cache

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
    
    # PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd
    
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - 
RUN apt-get install -y nodejs

RUN composer install --no-dev --optimize-autoloader
