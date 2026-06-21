# Docker Deploy Fix — PHP GD Extension

Patch ini memperbaiki error build:

```txt
Composer error: ext-gd is missing
```

Penyebabnya: stage `vendor` sebelumnya memakai image `composer:2`, sementara package Laravel membutuhkan extension `gd` saat `composer install`.

Perbaikan: stage `vendor` sekarang memakai `php:8.3-fpm-alpine`, menginstall extension PHP yang sama dengan container app, lalu menyalin binary Composer dari `composer:2`.

## Cara pakai

Extract patch ini ke root repo yang punya folder `sources/`, lalu rebuild:

```bash
cd /var/www/bookstore/sources
docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml build --no-cache bookstore_app
docker compose -f docker-compose.prod.yml up -d
```

Cek:

```bash
docker compose -f docker-compose.prod.yml ps
docker compose -f docker-compose.prod.yml logs --tail=100 bookstore_app
curl -I http://127.0.0.1:8090
```
