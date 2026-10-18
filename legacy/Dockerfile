# Reference environment for the ORIGINAL Laravel 5.8 application.
# This image exists only to run the legacy system locally against a
# production database export so the new application can be verified
# against it. It is not meant for deployment.
FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mysqli zip gd intl bcmath opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# The legacy app expects to be served from the repository root (routes
# reference /public explicitly), exactly like the GoDaddy deployment.
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && printf '<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/legacy.conf \
    && a2enconf legacy

RUN { \
      echo 'memory_limit=512M'; \
      echo 'upload_max_filesize=20M'; \
      echo 'post_max_size=20M'; \
      echo 'display_errors=On'; \
    } > /usr/local/etc/php/conf.d/legacy.ini

WORKDIR /var/www/html
COPY . /var/www/html
COPY docker/.htaccess /var/www/html/.htaccess

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
