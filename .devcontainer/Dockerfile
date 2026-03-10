FROM php:8.2-apache

# Optional: zusätzliche PHP-Extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

# Apache-Dokumentenroot auf /var/www/html belassen (Standard)
WORKDIR /var/www/html

# Composer ist im devcontainer-Image bereits enthalten

# Xdebug ist im devcontainer-Image bereits enthalten und kann über ENV konfiguriert werden
ENV XDEBUG_MODE=develop,debug
ENV XDEBUG_CONFIG="client_host=host.docker.internal client_port=9003"
