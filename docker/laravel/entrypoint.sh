cat << 'EOF' > ./docker/laravel/entrypoint.sh
#!/bin/bash

# Espera o MySQL estar pronto
until nc -z -v -w30 db 3306
do
  echo "Aguardando MySQL..."
  sleep 5
done

# Limpa e otimiza cache Laravel
php artisan config:clear
php artisan cache:clear
php artisan config:cache

# Executa comando padrão
exec "$@"
EOF
