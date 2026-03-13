FROM mcr.microsoft.com/devcontainers/php:8.2-apache-bullseye

# Optional: zusätzliche PHP-Extensions und msmtp als sendmail-Ersatz
RUN rm -f /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        libsqlite3-dev \
        msmtp \
    && docker-php-ext-install zip pdo_mysql pdo_sqlite \
    && ln -sf /usr/bin/msmtp /usr/sbin/sendmail \
    && rm -rf /var/lib/apt/lists/*

# Apache-Dokumentenroot auf /var/www/html belassen (Standard)
WORKDIR /var/www/html

# Apache-DocumentRoot auf /var/www/html/public umstellen
RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/default-ssl.conf || true

# mod_rewrite aktivieren, damit .htaccess mit RewriteEngine genutzt werden kann
RUN a2enmod rewrite

# Composer ist im devcontainer-Image bereits enthalten

# Xdebug ist im devcontainer-Image bereits enthalten und kann über ENV konfiguriert werden
ENV XDEBUG_MODE=develop,debug
ENV XDEBUG_CONFIG="client_host=host.docker.internal client_port=9003"

# Mailversand für Mailhog konfigurieren (msmtp als sendmail-Ersatz)
RUN echo 'sendmail_path = "/usr/sbin/sendmail -t"' > /usr/local/etc/php/conf.d/mailhog.ini \
    && echo "defaults" > /etc/msmtprc \
    && echo "account default" >> /etc/msmtprc \
    && echo "host mailhog" >> /etc/msmtprc \
    && echo "port 1025" >> /etc/msmtprc \
    && echo "auto_from on" >> /etc/msmtprc \
    && chmod 0644 /etc/msmtprc
