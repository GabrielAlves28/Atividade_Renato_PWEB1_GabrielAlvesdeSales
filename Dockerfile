
# Dockerfile – Sistema de Controle de Consumo de Água


# 1. Define a imagem base oficial do PHP 8.2 com FPM (FastCGI Process Manager)
#    O FPM é necessário para que o Nginx passe as requisições PHP ao container.
FROM php:8.2-fpm

# 2. Atualiza o índice de pacotes do apt-get e instala as bibliotecas
#    de sistema requeridas pelas extensões PHP:
#    - git: para possíveis dependências via VCS no composer
#    - curl: para requisições HTTP internas
#    - libpng-dev: suporte à extensão GD (imagens PNG)
#    - libonig-dev: suporte à extensão mbstring (strings multibyte)
#    - libxml2-dev: suporte a XML (usado pelo Laravel internamente)
#    - zip/unzip: para o Composer descompactar pacotes
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# 3. Instala as extensões PHP essenciais para o Laravel:
#    - pdo_mysql: conexão com banco de dados MySQL via PDO
#    - mbstring: manipulação de strings multibyte (internacionalização)
#    - exif: leitura de metadados de imagens (uploads)
#    - pcntl: controle de processos (usado por filas/workers)
#    - bcmath: aritmética de precisão arbitrária (cálculos financeiros)
#    - gd: manipulação de imagens (geração de thumbnails, captchas)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Copia o binário do Composer da imagem oficial composer:latest
#    para o PATH do sistema, sem precisar instalar o Composer manualmente.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Define o diretório de trabalho padrão dentro do container.
#    Todos os comandos seguintes serão executados em /var/www.
WORKDIR /var/www

# 6. Copia todos os arquivos do projeto Laravel para dentro do container.
#    O .dockerignore (se existir) excluirá pastas como vendor e node_modules.
COPY . .

# 7. Instala as dependências do projeto via Composer em modo produção:
#    - --no-dev: não instala dependências de desenvolvimento (testes, debug)
#    - --optimize-autoloader: gera o classmap otimizado para melhor performance
RUN composer install --no-dev --optimize-autoloader

# 8. Ajusta as permissões das pastas storage e bootstrap/cache para o
#    usuário www-data (usuário padrão do Nginx/PHP-FPM), permitindo que
#    o Laravel escreva logs, sessões, cache e arquivos de upload.
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 9. Copia e configura o script de entrypoint que roda migrations
#    automaticamente antes de iniciar o PHP-FPM.
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 10. Expõe a porta 8080 (porta HTTP padrão do Railway / php artisan serve).
EXPOSE 8080

# 11. Define o entrypoint: roda migrations e depois inicia o PHP-FPM.
#     O CMD é substituído pelo entrypoint.sh que chama 'exec php-fpm' no final.
CMD ["/usr/local/bin/entrypoint.sh"]
