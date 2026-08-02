FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql zip

# Copiar proyecto
COPY . .

# Instalar composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Build frontend
RUN npm install
RUN npm run build

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Run app
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=10000

