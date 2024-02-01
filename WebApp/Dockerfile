# Dockerfile pour le conteneur Apache avec PHP
FROM php:7.4-apache

# Activez l'extension PDO MySQL
RUN docker-php-ext-install pdo_mysql

# Installation de l'extension GD
# Installation de l'extension GD
RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        default-libmysqlclient-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Installation des dépendances Python
COPY requirements.txt ./
RUN apt-get install -y python3 python3-pip \
    && pip3 install --upgrade pip \
    && pip3 install -r requirements.txt

ENV PYTHON_PATH /usr/bin/python3

# Copiez le contenu de votre application
COPY ./Citymo /var/www/html/

# Exposez le port Apache
EXPOSE 80