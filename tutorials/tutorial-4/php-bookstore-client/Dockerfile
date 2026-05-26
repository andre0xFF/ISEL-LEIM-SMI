FROM php:8.3-apache

# Install PHP extensions required by the projects:
#   soap         → php-number-conversion-client (SoapClient)
#   curl         → php-book-store-client (cURL)
#   simplexml    → php-book-store-client (simplexml_load_file) — usually built-in
RUN apt-get update \
    && apt-get install -y --no-install-recommends libxml2-dev libcurl4-openssl-dev \
    && docker-php-ext-install soap \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite
