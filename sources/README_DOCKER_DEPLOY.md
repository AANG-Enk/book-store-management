# Deploy BookStore Laravel dengan Docker Container

Patch ini menambahkan deployment Docker production untuk project BookStore Laravel.

## File yang ditambahkan

```txt
sources/Dockerfile
sources/docker-compose.prod.yml
sources/.env.production.example
sources/docker/entrypoint.sh
sources/docker/nginx/Dockerfile
sources/docker/nginx/default.conf
sources/docker/php/production.ini
sources/docker/php/opcache.ini
```

## Arsitektur

```txt
VPS Host
└── /var/www/bookstore/sources
    ├── bookstore_nginx  -> expose host port 8090
    ├── bookstore_app    -> PHP 8.3 FPM Laravel
    └── bookstore_mysql  -> MySQL 8.4 internal Docker network
```

Laravel dapat diakses melalui:

```txt
http://IP_VPS:8090
```

Kalau pakai Nginx Proxy Manager, arahkan domain ke:

```txt
http://127.0.0.1:8090
```

## 1. Upload project ke VPS

Contoh folder:

```bash
mkdir -p /var/www/bookstore
cd /var/www/bookstore
```

Clone repo GitHub:

```bash
git clone https://github.com/USERNAME/REPO-KAMU.git .
```

Kalau struktur repo punya folder `sources`, masuk ke:

```bash
cd /var/www/bookstore/sources
```

## 2. Siapkan env production

```bash
cp .env.production.example .env
nano .env
```

Wajib ubah:

```env
APP_URL=http://IP_VPS:8090
DB_PASSWORD=PASSWORD_KUAT
DB_ROOT_PASSWORD=PASSWORD_ROOT_KUAT
```

Generate APP_KEY:

```bash
docker run --rm -v "$PWD":/app -w /app php:8.3-cli php artisan key:generate --show
```

Copy hasilnya ke `.env`:

```env
APP_KEY=base64:...
```

## 3. Build dan jalankan container

```bash
docker compose -f docker-compose.prod.yml up -d --build
```

Cek:

```bash
docker ps
curl -I http://127.0.0.1:8090
```

## 4. Jalankan seed pertama kali

Seeder default tidak otomatis dijalankan untuk menghindari reset data tidak sengaja. Untuk seed awal:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan db:seed --force
```

## 5. Command operasional

Lihat log:

```bash
docker compose -f docker-compose.prod.yml logs -f bookstore_app
```

Masuk app container:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_app sh
```

Clear cache:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan optimize:clear
```

Migrasi manual:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan migrate --force
```

Restart:

```bash
docker compose -f docker-compose.prod.yml restart
```

Stop:

```bash
docker compose -f docker-compose.prod.yml down
```

## 6. Nginx Proxy Manager

Jika VPS sudah menggunakan Nginx Proxy Manager:

```txt
Domain Names: bookstore.domainkamu.com
Scheme: http
Forward Hostname/IP: 127.0.0.1
Forward Port: 8090
Websockets Support: optional
Block Common Exploits: ON
SSL: Request new SSL Certificate
Force SSL: ON
```

Setelah domain aktif, ubah `.env`:

```env
APP_URL=https://bookstore.domainkamu.com
```

Lalu:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan optimize:clear
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan config:cache
```

## 7. Backup cepat

Backup database:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_mysql mysqldump -uroot -p bookstore > bookstore-backup.sql
```

Backup storage:

```bash
tar -czf bookstore-storage-backup.tar.gz -C /var/lib/docker/volumes bookstore_storage
```

## 8. Catatan keamanan

- Jangan commit `.env` ke GitHub.
- Gunakan password database kuat.
- Jangan expose MySQL ke publik.
- `APP_DEBUG=false` untuk production.
- Nginx container hanya expose port `8090`.
- Untuk akses publik domain, lebih baik lewat Nginx Proxy Manager.
