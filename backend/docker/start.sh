#!/bin/sh

# Générer la clé Laravel si absente
php artisan key:generate --force

# Migrations
php artisan migrate --force

# Démarrer PHP-FPM en arrière-plan
php-fpm &

# Démarrer Nginx au premier plan
nginx -g "daemon off;"
