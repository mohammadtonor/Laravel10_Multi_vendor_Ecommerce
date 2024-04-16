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

# Add the user UID:1000, GID:1000, home at /app
RUN groupadd -r app -g 1000 && useradd -u 1000 -r -g app -m -d /app -s /sbin/nologin -c "App user" app && \
    chmod 755 /var/www/

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
    
# PHP Extension
RUN docker-php-ext-install gettext intl pdo_mysql gd
    
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


USER app

WORKDIR /var/www/html

COPY . .

# USER root

# COPY default.conf /etc/apache2/sites-enabled/000-default.conf
    
RUN composer install
# RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - 
# RUN apt-get install -y nodejs

EXPOSE 80