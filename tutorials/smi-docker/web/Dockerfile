FROM php:5.6-apache

# Debian Stretch is EOL; use the Debian archive mirror and bypass signature expiry
RUN echo "deb [trusted=yes] http://archive.debian.org/debian stretch main" > /etc/apt/sources.list \
 && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until \
 && echo 'Acquire::AllowInsecureRepositories "true";' > /etc/apt/apt.conf.d/99allow-insecure

RUN apt-get update \
 && apt-get install -y --no-install-recommends --allow-unauthenticated \
    msmtp ca-certificates unzip \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-install mysqli pdo pdo_mysql mbstring \
 && pecl install xdebug-2.5.5 \
 && docker-php-ext-enable xdebug

RUN a2enmod rewrite

COPY php-custom.ini /usr/local/etc/php/conf.d/zz-custom.ini
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]
