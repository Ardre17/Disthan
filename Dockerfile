FROM php:8.2-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto
WORKDIR /app
COPY . .

# Instalar Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos
RUN chmod -R 777 storage bootstrap/cache

# Puerto
EXPOSE 10000

# Comando
CMD php artisan config:clear && php artisan migrate --force || true && php artisan serve --host=0.0.0.0 --port=10000