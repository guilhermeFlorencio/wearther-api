# Use uma imagem do PHP com extensões necessárias
FROM php:8.2-fpm

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure o diretório do Laravel
WORKDIR /var/www/html

# Copie os arquivos do projeto para o contêiner
COPY . .

# Instale as dependências do Laravel
RUN composer install --optimize-autoloader --no-dev

# Configure permissões para o diretório de cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expõe a porta para desenvolvimento
EXPOSE 8000

# Comando padrão para iniciar o servidor
CMD php artisan serve --host=0.0.0.0 --port=8000
