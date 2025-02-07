# Utilisation de l'image PHP avec Apache
FROM php:8.1-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activer les modules Apache (si besoin)
RUN a2enmod rewrite

# Copier le fichier de configuration PHP personnalisé
COPY docker/php.ini /usr/local/etc/php/

# Définir le répertoire de travail
WORKDIR /var/www/html

# Exposer le port Apache
EXPOSE 80
