# Verwende das offizielle PHP-Image mit Apache
FROM php:8.3-apache

# Installiere Abhängigkeiten und notwendige Bibliotheken
RUN apt-get update && apt-get install -y \
    sendmail \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libzip-dev \
    zlib1g-dev

# Installiere PHP-Erweiterungen
RUN docker-php-ext-install mysql exif zip

# Konfiguriere und installiere die GD-Erweiterung mit Unterstützung für verschiedene Bildformate
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd

# Aktiviere das Apache-Modul mod_rewrite
RUN a2enmod rewrite

# Kopiere den Anwendungscode in das Apache-Stammverzeichnis
COPY . /var/www/html/

# Setze das Arbeitsverzeichnis
WORKDIR /var/www/html/

# Exponiere den Standard-Apache-Port
EXPOSE 80