FROM php:7.4-apache

# Installation de l'extension GD
RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Installation des dépendances Python
COPY requirements.txt ./
RUN apt-get install -y python3 python3-pip \
    && pip3 install --upgrade pip \
    && pip3 install -r requirements.txt

# Copiez le contenu de votre application
COPY ./garo-estate-master /var/www/html/

# Exposez le port 80 pour le serveur Apache
EXPOSE 80

# Configuration Apache pour définir les fichiers index
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

# Commande par défaut pour lancer Apache
CMD ["apache2-foreground"]
