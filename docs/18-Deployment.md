# 18 - Deployment

# 🚀 Deployment ke Shared Hosting (cPanel)

Deployment merupakan tahap akhir dari pembangunan Sistem Informasi Toko Buku. Pada tahap ini aplikasi Laravel dipindahkan dari lingkungan pengembangan (localhost) ke server hosting sehingga dapat diakses secara online.

Pada modul ini digunakan **Shared Hosting dengan cPanel**, karena merupakan layanan hosting yang paling umum digunakan oleh mahasiswa.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Menyiapkan project Laravel untuk Production
* Upload project ke cPanel
* Import Database
* Menghubungkan Storage
* Mengatur Environment Production
* Menjalankan aplikasi secara online

---

# Persiapan Sebelum Upload

Pastikan project sudah selesai.

Checklist.

* Semua fitur berjalan
* Tidak ada Error
* Database final
* Testing selesai
* Backup project

---

# Struktur Project

Project Laravel terdiri dari.

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
vendor/
artisan
composer.json
.env
```

---

# Backup Database

Export database menggunakan phpMyAdmin.

Format.

```text
SQL
```

Simpan file.

```text
tokobuku.sql
```

---

# Login cPanel

Masuk ke.

```text
https://domainanda.com/cpanel
```

Gunakan akun hosting yang telah diberikan.

---

# Upload Project

Compress project menjadi.

```text
project.zip
```

Upload ke.

```text
Home Directory
```

Kemudian.

Extract.

---

# Folder Public

Isi folder.

```text
public
```

Dipindahkan ke.

```text
public_html
```

Contoh.

```text
Laravel

app

bootstrap

config

resources

routes

storage

vendor

artisan
```

berada di.

```text
/home/username/project/
```

Sedangkan.

```text
index.php

assets

storage
```

berada di.

```text
public_html/
```

---

# Mengubah index.php

Edit file.

```text
public_html/index.php
```

Sesuaikan path.

Contoh.

```php
require __DIR__.'/../project/vendor/autoload.php';

$app = require_once __DIR__.'/../project/bootstrap/app.php';
```

Sesuaikan nama folder project dengan lokasi sebenarnya pada hosting.

---

# Membuat Database

Masuk ke.

```text
MySQL Database
```

Buat.

* Database
* User Database
* Password

Kemudian.

Assign User ke Database dengan hak akses **ALL PRIVILEGES**.

---

# Import Database

Masuk.

```text
phpMyAdmin
```

Import file.

```text
tokobuku.sql
```

Pastikan seluruh tabel berhasil dibuat.

---

# Konfigurasi .env

Sesuaikan konfigurasi.

```text
APP_NAME="Toko Buku"

APP_ENV=production

APP_DEBUG=false

APP_URL=https://domainanda.com
```

Database.

```text
DB_CONNECTION=mysql

DB_HOST=localhost

DB_PORT=3306

DB_DATABASE=nama_database

DB_USERNAME=username_database

DB_PASSWORD=password_database
```

---

# Generate Application Key

Jika belum tersedia.

Jalankan.

```bash
php artisan key:generate
```

Apabila tidak memiliki akses Terminal, salin file `.env` dari project lokal yang sudah memiliki `APP_KEY`.

---

# Storage Link

Jika hosting menyediakan Terminal.

Jalankan.

```bash
php artisan storage:link
```

Jika tidak tersedia.

Buat symbolic link melalui cPanel atau gunakan fitur **File Manager** sesuai dukungan hosting.

---

# Permission Folder

Pastikan folder berikut dapat ditulis.

```text
storage/

bootstrap/cache/
```

Permission umum.

```text
755
```

atau.

```text
775
```

Sesuai kebijakan hosting.

---

# Optimasi Laravel

Jika tersedia Terminal.

Jalankan.

```bash
php artisan config:cache

php artisan route:cache

php artisan view:cache
```

Untuk mempercepat performa aplikasi.

---

# Upload Vendor

Apabila hosting tidak menyediakan Composer.

Upload folder.

```text
vendor
```

Dari project lokal.

Pastikan sebelumnya telah menjalankan.

```bash
composer install --optimize-autoloader --no-dev
```

di komputer lokal.

---

# Pengujian Website

Pastikan halaman berikut dapat diakses.

* Home
* Login
* Register
* Dashboard Admin
* Dashboard Customer
* Katalog Buku
* Checkout
* Laporan

---

# Pengujian Upload

Uji.

* Upload Cover Buku
* Upload Bukti Transfer
* Upload Foto Profile

Pastikan seluruh file tersimpan dengan baik.

---

# Pengujian Email (Opsional)

Jika menggunakan email.

Pastikan.

* SMTP aktif
* Email terkirim

Jika belum menggunakan SMTP, fitur email dapat dinonaktifkan tanpa memengaruhi fungsi utama aplikasi.

---

# Checklist Deployment

Pastikan.

* [ ] Project berhasil di-upload.
* [ ] Database berhasil di-import.
* [ ] File `.env` sesuai.
* [ ] APP_KEY tersedia.
* [ ] Storage dapat diakses.
* [ ] Gambar tampil normal.
* [ ] Login berhasil.
* [ ] CRUD berjalan.
* [ ] Checkout berjalan.
* [ ] Upload Bukti Transfer berjalan.
* [ ] Dashboard tampil normal.
* [ ] Laporan dapat diakses.
* [ ] Tidak ada Error 500.
* [ ] Tidak ada Error 404.

---

# Dokumentasi

Simpan beberapa screenshot.

* Halaman Home
* Login
* Dashboard Admin
* Dashboard Customer
* Data Buku
* Keranjang
* Checkout
* Pembayaran
* Laporan
* Profile

Screenshot ini dapat digunakan pada laporan Tugas Akhir maupun saat presentasi sidang.

---

# Best Practice

Gunakan aturan berikut.

* Gunakan `APP_ENV=production`.
* Gunakan `APP_DEBUG=false`.
* Jangan mengunggah file `.env` ke repositori Git.
* Lakukan backup database secara berkala.
* Simpan salinan project sebelum deployment.
* Gunakan password database yang kuat.
* Hapus file yang tidak digunakan dari `public_html`.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah:

* Berjalan secara online pada Shared Hosting (cPanel)
* Terhubung dengan database MySQL
* Menampilkan gambar melalui Laravel Storage
* Siap digunakan oleh Admin dan Customer
* Siap dipresentasikan pada sidang Tugas Akhir

---

# Penutup Project

Selamat, Anda telah menyelesaikan pembangunan **Sistem Informasi Toko Buku Berbasis Web menggunakan Laravel 12 dan Bootstrap 5**.

Project ini telah mencakup seluruh komponen utama yang umum digunakan pada aplikasi e-commerce sederhana, yaitu:

* Website Publik (Katalog Buku)
* Sistem Login Multi Role
* Dashboard Admin
* Dashboard Customer
* Manajemen Buku
* Manajemen Kategori
* Manajemen Supplier
* Keranjang Belanja
* Checkout
* Pembayaran Manual (Siap Integrasi Midtrans)
* Manajemen Pesanan
* Laporan & Statistik
* Manajemen Profil
* Pengujian Sistem
* Deployment ke Shared Hosting (cPanel)

Dengan menyelesaikan seluruh 18 modul ini, mahasiswa telah menghasilkan sebuah aplikasi yang layak digunakan sebagai proyek Tugas Akhir dan dapat dikembangkan lebih lanjut dengan fitur seperti Midtrans, RajaOngkir, notifikasi email, dan dashboard analitik yang lebih lengkap.
