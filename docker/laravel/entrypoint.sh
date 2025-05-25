#!/bin/bash

set -e

echo "Starting Laravel App..."

# Descomente para aguardar o MySQL antes de iniciar:
# until nc -z -v -w30 mysql_db 3306; do
#   echo "Waiting for MySQL..."
#   sleep 1
# done

php-fpm
