# Tahap 17A — Shipping Manual, Ongkir Manual, dan Resi

Patch ini menambahkan alur pengiriman manual untuk BookStore Laravel.

## Fitur yang ditambahkan

1. Customer mengisi detail pengiriman saat checkout:
   - Provinsi
   - Kota/Kabupaten
   - Kode pos
   - Alamat lengkap
   - Catatan pengiriman

2. Order baru masuk status `Menunggu Ongkir`.

3. Admin dapat mengisi:
   - Kurir
   - Layanan pengiriman
   - Ongkos kirim manual
   - Nomor resi
   - Tanggal dikirim

4. Setelah admin menyimpan ongkir, status order otomatis menjadi `Menunggu Pembayaran`.

5. Customer baru bisa upload bukti pembayaran setelah ongkir dikonfirmasi admin.

## Cara pasang file

Copy setiap file ke lokasi asli sesuai nama file:

- `17A__database_migrations_2026_06_21_000001_add_manual_shipping_fields_to_orders_table.php`
  → `database/migrations/2026_06_21_000001_add_manual_shipping_fields_to_orders_table.php`

- `17A__app_Models_Order.php`
  → `app/Models/Order.php`

- `17A__app_Http_Controllers_Customer_CheckoutController.php`
  → `app/Http/Controllers/Customer/CheckoutController.php`

- `17A__app_Http_Controllers_Admin_OrderController.php`
  → `app/Http/Controllers/Admin/OrderController.php`

- `17A__app_Http_Controllers_Customer_PaymentController.php`
  → `app/Http/Controllers/Customer/PaymentController.php`

- `17A__routes_web.php`
  → `routes/web.php`

- `17A__resources_views_customer_checkout_create.blade.php`
  → `resources/views/customer/checkout/create.blade.php`

- `17A__resources_views_admin_orders_show.blade.php`
  → `resources/views/admin/orders/show.blade.php`

- `17A__resources_views_customer_orders_show.blade.php`
  → `resources/views/customer/orders/show.blade.php`

- `17A__resources_views_customer_payments_create.blade.php`
  → `resources/views/customer/payments/create.blade.php`

## Setelah pasang

Jalankan:

```bash
php artisan migrate
php artisan optimize:clear
```

Kalau di Docker production:

```bash
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan migrate --force
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan optimize:clear
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan config:cache
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan route:cache
docker compose -f docker-compose.prod.yml exec bookstore_app php artisan view:cache
```

Jika file masuk ke Docker image dan bukan bind mount, rebuild image setelah copy file.
