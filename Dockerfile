FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar proyecto
COPY . .

# Instalar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# 🔥 INSTALAR Y COMPILAR VITE
RUN npm install
RUN npm run build

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Limpiar cache + migrar + correr
CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force || true && php artisan serve --host=0.0.0.0 --port=10000

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
