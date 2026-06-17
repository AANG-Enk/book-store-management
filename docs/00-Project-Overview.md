# 00 - Project Overview

# 📚 BookStore - Sistem Informasi Penjualan Buku Berbasis Web

> Build BookStore with Laravel 12 + Bootstrap 5

---

# Tentang Project

Project ini merupakan aplikasi **Sistem Informasi Penjualan Buku** berbasis web yang dibangun menggunakan **Laravel 12** dan **Bootstrap 5**.

Aplikasi dirancang sebagai studi kasus untuk mahasiswa tingkat akhir dengan menggabungkan konsep **Website Katalog Buku** dan **Dashboard Admin** dalam satu sistem.

Project ini tidak hanya berfokus pada CRUD, tetapi juga mengimplementasikan alur bisnis sederhana seperti pengelolaan stok, pemesanan buku, pembayaran manual, serta laporan transaksi.

---

# Tujuan Project

Setelah menyelesaikan project ini, mahasiswa diharapkan memahami:

* Struktur project Laravel
* Authentication & Authorization
* CRUD menggunakan Eloquent ORM
* Relationship Database
* Migration & Seeder
* Form Validation
* Upload File
* Session & Shopping Cart
* Dashboard Admin
* Manual Payment
* Report PDF & Excel
* Best Practice penulisan kode Laravel

---

# Teknologi yang Digunakan

| Teknologi       | Keterangan         |
| --------------- | ------------------ |
| Laravel 12      | Framework PHP      |
| PHP 8.3+        | Bahasa Pemrograman |
| MySQL           | Database           |
| Bootstrap 5.3   | CSS Framework      |
| Bootstrap Icons | Icon               |
| Blade Template  | Template Engine    |
| SweetAlert2     | Alert Dialog       |
| Chart.js        | Dashboard Chart    |
| DomPDF          | Export PDF         |
| Laravel Excel   | Export Excel       |

---

# Konsep Sistem

Project akan dibagi menjadi **3 Area Utama**.

## 1. Public Website

Website yang dapat diakses oleh seluruh pengunjung tanpa login.

Fitur:

* Home
* Katalog Buku
* Detail Buku
* Kategori
* Tentang Kami
* Kontak
* Login
* Register

---

## 2. Customer Area

Area khusus pelanggan setelah login.

Fitur:

* Dashboard
* Profil
* Katalog Buku
* Keranjang
* Checkout
* Upload Bukti Transfer
* Riwayat Pesanan
* Detail Pesanan

---

## 3. Admin Dashboard

Area khusus administrator.

Fitur:

* Dashboard
* Master Buku
* Master Kategori
* Master Supplier
* Master Customer
* Manajemen Pesanan
* Manajemen Pembayaran
* Laporan
* Profil

---

# Flow Sistem

```text
Guest

↓

Melihat Katalog Buku

↓

Register

↓

Login

↓

Customer Dashboard

↓

Tambah ke Keranjang

↓

Checkout

↓

Transfer Manual

↓

Upload Bukti Transfer

↓

Admin Verifikasi

↓

Pesanan Diproses

↓

Pesanan Selesai
```

---

# Sistem Pembayaran

Pada project ini pembayaran menggunakan **Transfer Bank Manual**.

Flow pembayaran:

1. Customer melakukan checkout.
2. Customer memilih rekening tujuan.
3. Customer melakukan transfer.
4. Customer mengunggah bukti pembayaran.
5. Admin melakukan verifikasi pembayaran.
6. Status pesanan diperbarui secara manual.

> **Catatan:** Arsitektur aplikasi akan disiapkan agar mudah diintegrasikan dengan payment gateway seperti Midtrans di kemudian hari, namun implementasi payment gateway tidak menjadi bagian dari project utama.

---

# Role Pengguna

## Administrator

Hak akses penuh terhadap sistem.

* Dashboard
* Kelola Buku
* Kelola Kategori
* Kelola Supplier
* Kelola Customer
* Kelola Pesanan
* Verifikasi Pembayaran
* Laporan
* Profil

---

## Customer

Hak akses:

* Dashboard
* Profil
* Keranjang
* Checkout
* Riwayat Pesanan

---

# Struktur Project

```text
Public Website

↓

Customer Area

↓

Admin Dashboard
```

---

# Struktur Dokumentasi

Seluruh proses pembangunan project akan dibagi menjadi beberapa modul agar mudah dipelajari.

```text
docs/

00-Project-Overview.md
01-Setup-Project.md
02-Authentication.md
03-Role-Permission.md
04-Layout-Bootstrap.md
05-Public-Website.md
06-Customer-Module.md
07-Admin-Dashboard.md
08-Master-Kategori.md
09-Master-Buku.md
10-Master-Supplier.md
11-Keranjang.md
12-Checkout.md
13-Pembayaran-Manual.md
14-Manajemen-Pesanan.md
15-Laporan.md
16-Profile.md
17-Testing.md
18-Deployment.md
```

---

# Roadmap Pengembangan

| Tahap | Modul               |
| ----- | ------------------- |
| 01    | Setup Project       |
| 02    | Authentication      |
| 03    | Role & Permission   |
| 04    | Layout Bootstrap    |
| 05    | Public Website      |
| 06    | Customer Module     |
| 07    | Admin Dashboard     |
| 08    | Master Kategori     |
| 09    | Master Buku         |
| 10    | Master Supplier     |
| 11    | Shopping Cart       |
| 12    | Checkout            |
| 13    | Manual Payment      |
| 14    | Manajemen Pesanan   |
| 15    | Dashboard & Laporan |
| 16    | Profile             |
| 17    | Testing             |
| 18    | Deployment          |

---

# Standar Pengembangan

Selama proses pengembangan, beberapa standar berikut akan diterapkan:

* Menggunakan Resource Controller.
* Menggunakan Eloquent Relationship.
* Menggunakan Migration & Seeder.
* Menggunakan Blade Template.
* Menggunakan Bootstrap 5.
* Validasi menggunakan Form Request atau Validator Laravel.
* Menggunakan penamaan file dan class sesuai standar PSR-12.
* Setiap fitur diselesaikan dan diuji sebelum melanjutkan ke tahap berikutnya.

---

# Hasil Akhir Project

Setelah seluruh modul selesai, aplikasi akan memiliki fitur:

* Website katalog buku untuk publik.
* Dashboard pelanggan.
* Dashboard administrator.
* Manajemen buku dan kategori.
* Shopping cart.
* Checkout.
* Pembayaran manual dengan upload bukti transfer.
* Verifikasi pembayaran oleh admin.
* Laporan transaksi.
* Dashboard statistik.
* Export PDF dan Excel.

---

# Catatan

Project ini disusun untuk kebutuhan pembelajaran dan tugas akhir mahasiswa. Fokus utama adalah memahami implementasi Laravel secara bertahap melalui studi kasus yang mendekati kebutuhan dunia nyata, namun tetap mempertahankan tingkat kompleksitas yang sesuai untuk proses pembelajaran.
