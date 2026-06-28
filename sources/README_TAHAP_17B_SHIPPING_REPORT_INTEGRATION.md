# Tahap 17B — Shipping Display & Report Integration

Patch ini melanjutkan Tahap 17A. Pastikan 17A sudah dipasang dan migrasi `add_manual_shipping_fields_to_orders_table` sudah berjalan.

## Isi Perubahan

- Admin order list menampilkan info pengiriman, ongkir, subtotal, total, dan resi.
- Customer order list menampilkan info pengiriman, ongkir, subtotal, total, dan resi.
- Dashboard laporan menampilkan subtotal produk dan total ongkir.
- Laporan penjualan menampilkan kolom subtotal, ongkir, grand total, kurir, layanan, dan resi.
- Export Excel laporan penjualan ikut membawa data ongkir/resi.
- Export PDF laporan penjualan ikut membawa data ongkir/resi.
- Filter status laporan/order sudah mengenali status `Menunggu Ongkir`.

## File yang Berubah

- `app/Http/Controllers/Admin/ReportController.php`
- `app/Exports/SalesReportExport.php`
- `resources/views/admin/orders/index.blade.php`
- `resources/views/customer/orders/index.blade.php`
- `resources/views/admin/reports/index.blade.php`
- `resources/views/admin/reports/sales.blade.php`
- `resources/views/admin/reports/pdf/sales.blade.php`

## Cara Pasang di Local

Extract ZIP ke root project yang memiliki folder `sources/`, lalu jalankan:

```bash
cd sources
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Cara Pasang di VPS Docker

Extract ZIP ke `/var/www/bookstore`, lalu jalankan:

```bash
cd /var/www/bookstore/sources

docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml build --no-cache bookstore_app
docker compose -f docker-compose.prod.yml up -d

docker compose -f docker-compose.prod.yml exec bookstore_app php artisan optimize:clear
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan config:cache
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan route:cache
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan view:cache
```

## Checklist Test

1. Customer checkout order baru.
2. Admin buka detail order dan isi ongkir manual.
3. Cek `/admin/orders`, kolom ongkir dan pengiriman muncul.
4. Cek `/customer/orders`, customer melihat status ongkir dan total akhir.
5. Cek `/admin/reports`.
6. Cek `/admin/reports/sales`.
7. Coba export Excel dan PDF laporan penjualan.

## Catatan

Patch ini belum menambah integrasi RajaOngkir atau payment gateway. Fitur tersebut tetap diposisikan sebagai pengembangan lanjutan agar scope TA tidak melebar.
