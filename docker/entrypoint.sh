#!/bin/bash

# Aguarda o banco de dados subir (ajuste o tempo se necessário)
echo "⏳ Aguardando banco de dados..."
sleep 10

# Roda migrations e seeders
echo "⚙️ Executando migrations e seeders..."
php artisan migrate:fresh --seed

# Inicia o servidor PHP embutido
echo "🚀 Iniciando servidor Lumen em http://0.0.0.0:8000"
php -S 0.0.0.0:8000 -t public
