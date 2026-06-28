# Tahap 17C — Manual Shipment Workflow

Patch ini melanjutkan Tahap 17A dan 17B. Fokusnya adalah menyempurnakan alur pengiriman manual setelah admin menentukan ongkir dan customer mengunggah pembayaran.

## Prasyarat

Patch ini wajib dipasang setelah:

1. Tahap 17A — Shipping Manual + Ongkir Manual + Resi
2. Tahap 17B — Shipping Display & Report Integration

## File yang berubah

```txt
sources/app/Models/Order.php
sources/app/Http/Controllers/Admin/OrderController.php
sources/routes/web.php
sources/resources/views/admin/orders/show.blade.php
sources/resources/views/customer/orders/show.blade.php
sources/README_TAHAP_17C_MANUAL_SHIPMENT_WORKFLOW.md
```

## Fitur yang ditambahkan

```txt
- Menambah status order baru: shipped / Dikirim.
- Menambah status label dan badge untuk Dikirim.
- Menambah timeline pesanan/pengiriman pada detail admin dan customer.
- Menambah quick action admin:
  - Tandai Diproses
  - Simpan & Tandai Dikirim
  - Tandai Selesai
- Validasi agar pesanan tidak bisa dikirim sebelum pembayaran diverifikasi.
- Validasi agar nomor resi wajib diisi sebelum pesanan ditandai dikirim.
- Search admin order sekarang bisa mencari tracking number dan kurir.
```

## Alur setelah patch

```txt
1. Customer checkout.
2. Order masuk status Menunggu Ongkir.
3. Admin isi kurir, layanan, ongkir.
4. Order berubah menjadi Menunggu Pembayaran.
5. Customer upload bukti transfer.
6. Admin verifikasi pembayaran.
7. Admin tandai order Diproses.
8. Admin isi/cek nomor resi lalu tandai Dikirim.
9. Customer melihat timeline dan nomor resi.
10. Admin tandai order Selesai.
```

## Cara pasang di VPS Docker

Extract ZIP ke folder root yang memiliki folder `sources/`, misalnya:

```bash
cd /var/www/bookstore
# extract ZIP di sini, bukan di /var/www/bookstore/sources
```

Lalu rebuild container app karena file PHP/Blade berubah:

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

## Catatan

Patch ini tidak menambah tabel/kolom baru. Status `shipped` disimpan di kolom `orders.status` yang sudah ada.

Jika ada order lama yang sudah dikirim tetapi statusnya masih `processing`, admin bisa membuka detail order, mengisi nomor resi, lalu klik `Simpan & Tandai Dikirim`.
