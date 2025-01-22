# Laravel va Apache uchun PHP muhitni sozlash
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl && \
    docker-php-ext-install \
    intl \
    mbstring \
    zip \
    pdo \
    pdo_mysql && \
    a2enmod rewrite

# Composerni o'rnatish
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apachening asosiy katalogini Laravel public katalogiga yo'naltirish
WORKDIR /var/www/html
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# Laravel loyihasi fayllarini konteynerga nusxalash
COPY . .

# Composer orqali paketlarni o'rnatish
RUN composer install --no-dev --optimize-autoloader

# Ruxsatlarni to'g'ri sozlash
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Portni ochish
EXPOSE 80

# Apache serverni ishga tushirish
CMD ["apache2-foreground"]
