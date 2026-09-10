FROM php:8.2-apache

# Instala a extensão PDO MySQL para permitir que o PHP se conecte ao MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Define a pasta da aplicação dentro do container
WORKDIR /var/www/html

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite