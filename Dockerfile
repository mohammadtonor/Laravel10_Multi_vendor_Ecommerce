# FROM php:8.1.0-apache
# WORKDIR /var/www/html

# # Mod Rewrite
# RUN a2enmod rewrite

# # Linux Library
# RUN apt-get update -y && apt-get install -y \
#     libicu-dev \
#     libmariadb-dev \
#     unzip zip \
#     zlib1g-dev \
#     libzip-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libpng-dev

# # Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # PHP Extension
# RUN docker-php-ext-install gettext intl pdo_mysql gd zip

# RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd

# WORKDIR /var/www/html

# COPY . .

# RUN chown www-data:www-data -R ./storage
# RUN composer install
FROM php:8.1.0-apache
WORKDIR /var/www/html

# Mod Rewrite
RUN a2enmod rewrite

# Linux Library
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd zip

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

WORKDIR /var/www/html

COPY . .

RUN chown www-data:www-data -R ./storage

RUN composer install

RUN php artisan migrate --force
RUN php artisan db:seed --force

RUN php artisan config:cache
RUN artisan route:cache
