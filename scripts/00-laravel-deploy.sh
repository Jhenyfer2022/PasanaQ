#!/usr/bin/env bash
#echo "Running composer"
#composer global require hirak/prestissimo
#composer install --no-dev --working-dir=/var/www/html

#echo "Caching config..."
#php artisan config:cache

#echo "Caching routes..."
#php artisan route:cache

#echo "Running migrations..."
#php artisan migrate --force


#!/usr/bin/env bash

# Instala Composer localmente en el contenedor si no está instalado
if [ ! -f /usr/local/bin/composer ]; then
    echo "Installing Composer locally..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
    echo "Composer installed."
fi

# Instala las dependencias de Composer
echo "Running composer install..."
/usr/local/bin/composer install --no-dev --working-dir=/var/www/html

# Caché de configuración de Laravel
echo "Caching config..."
php /var/www/html/artisan config:cache

# Caché de rutas de Laravel
echo "Caching routes..."
php /var/www/html/artisan route:cache

# Ejecuta las migraciones de la base de datos
echo "Running migrations..."
php /var/www/html/artisan migrate --force
