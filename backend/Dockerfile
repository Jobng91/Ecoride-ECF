# Installation de PHP 8.3

FROM php:8.3-fpm


# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libjpeg-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo zip

# Installation de MongoDB pour le NoSQL
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Installation de Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définition du dossier de travail 
WORKDIR /app-backend

COPY . .

# Installation des dépendances PHP du projet
RUN composer install --no-interaction --prefer-dist

# Mise à jour du système
RUN apt-get update && apt-get upgrade -y && apt-get clean && rm -rf /var/lib/apt/lists/*


# Exposer le port 
EXPOSE 9000

# Démarrer le serveur PHP-FPM
CMD ["php-fpm"]