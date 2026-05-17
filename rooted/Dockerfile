FROM php:8.2-cli-bullseye

ARG INSTALL_XDEBUG=false

# Install system dependencies + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql zip curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Optionally install & configure Xdebug
RUN if [ "$INSTALL_XDEBUG" = "true" ]; then \
        pecl install xdebug \
        && docker-php-ext-enable xdebug \
        && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /workspace

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
