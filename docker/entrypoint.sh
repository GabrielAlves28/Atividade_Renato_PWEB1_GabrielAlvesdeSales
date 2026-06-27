#!/bin/sh
# =============================================================
# entrypoint.sh - Script de inicialização do container Laravel
# Executa automaticamente as migrations antes de subir o PHP-FPM
# =============================================================

echo ">>> Aguardando banco de dados MySQL ficar disponível..."

# Esperar o MySQL aceitar conexões (até 60 segundos)
until php -r "
try {
    \$pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT', '3306'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );
    echo 'Banco disponivel!' . PHP_EOL;
    exit(0);
} catch (Exception \$e) {
    echo 'Aguardando banco...' . PHP_EOL;
    exit(1);
}
"; do
    sleep 2
done

echo ">>> Rodando migrations..."
php artisan migrate --force

echo ">>> Rodando seeds (usuarios de teste)..."
php artisan db:seed --force

echo ">>> Limpando e otimizando caches de producao..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ">>> Iniciando PHP-FPM..."
exec php-fpm
