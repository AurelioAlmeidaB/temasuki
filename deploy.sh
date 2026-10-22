#!/usr/bin/env bash
# Atualiza a aplicação no servidor depois que o código foi sincronizado com origin/main.
# Executado pela GitHub Action (.github/workflows/deploy-to-ec2.yml).
set -euo pipefail

cd "$(dirname "$0")"

composer install --no-dev --optimize-autoloader --no-interaction --no-progress

touch database/database.sqlite
php artisan migrate --force

mkdir -p public/img/pratos
chmod -R ug+rwX storage bootstrap/cache database public/img/pratos

php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Limpa o OPcache para o PHP-FPM servir o código novo
sudo systemctl reload php8.5-fpm

echo "Deploy concluído: $(git log --oneline -1)"
