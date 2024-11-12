# Используем PHP 8.2 с поддержкой FPM
FROM php:8.2-fpm

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libicu-dev \
    libxml2-dev \
    libzip-dev \
    zlib1g-dev \
    curl \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip intl \
    && (pecl install xdebug || true) \
    && docker-php-ext-enable xdebug

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Устанавливаем Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Копируем файлы проекта
COPY . /var/www/sites

# Устанавливаем права для пользователя Apache
RUN chown -R www-data:www-data /var/www/sites
RUN chmod -R 777 /var/www/sites/var/cache /var/www/sites/var/log

# Рабочая директория для PHP
WORKDIR /var/www/sites


CMD ["symfony", "server:start"]