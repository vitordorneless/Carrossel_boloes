FROM php:8.4-apache

# Set working directory
WORKDIR /var/www/html

# Instalar dependências do sistema e extensões PHP necessárias para Laravel e RabbitMQ
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    librabbitmq-dev \
    libssl-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Ativar o módulo mod_rewrite do Apache (necessário para as rotas do Laravel)
RUN a2enmod rewrite

# Instalar a versão mais recente do Composer copiando da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Ajustar permissões para o usuário www-data do Apache
RUN chown -R www-data:www-data /var/www/html
