FROM php:8.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    libpq-dev zip unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP (PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/app

# Crear usuario no-root ANTES de fijar permisos, para poder usarlo en el chown
ARG UID=1000
ARG GID=1000
RUN groupadd -g ${GID} linux || true \
    && useradd -u ${UID} -g ${GID} -m -d /home/linux -s /bin/bash linux || true

# Nota: en runtime el proyecto se monta como bind mount (.:/var/www/app),
# por lo que esto solo prepara la imagen para el caso en que se use SIN
# bind mount (por ejemplo, un build de producción con COPY . .).
# Si sigues usando bind mount, ajusta los permisos también en el HOST:
#   chown -R 1000:1000 storage bootstrap/cache
RUN mkdir -p storage/framework/views \
             storage/framework/cache \
             storage/framework/sessions \
             storage/logs \
             bootstrap/cache \
    && chown -R linux:linux storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

ENV HOME=/home/linux
USER linux

EXPOSE 9000
CMD ["php-fpm"]