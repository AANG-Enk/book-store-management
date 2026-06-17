# 01 - Setup Project

# 🚀 Setup Project Laravel 12

Pada tahap ini kita akan mempersiapkan seluruh kebutuhan project sebelum mulai membuat fitur aplikasi.

Target akhir pada tahap ini adalah aplikasi Laravel dapat berjalan dengan baik dan siap untuk dikembangkan pada tahap berikutnya.

---

# Tujuan Pembelajaran

Setelah menyelesaikan tahap ini mahasiswa diharapkan mampu:

* Menginstall Laravel 12
* Menghubungkan Laravel dengan MySQL
* Menjalankan project menggunakan Artisan
* Memahami struktur folder Laravel
* Menggunakan Git sebagai Version Control
* Menyiapkan project untuk pengembangan berikutnya

---

# Software yang Digunakan

Pastikan software berikut sudah terinstall.

| Software           | Versi Minimum |
| ------------------ | ------------- |
| PHP                | 8.3           |
| Composer           | Terbaru       |
| NodeJS             | LTS           |
| MySQL              | 8.x           |
| Git                | Terbaru       |
| Visual Studio Code | Terbaru       |

---

# Membuat Project Baru

Buka Terminal kemudian jalankan perintah berikut.

```bash
composer create-project laravel/laravel bookstore
```

Masuk ke folder project.

```bash
cd bookstore
```

---

# Menjalankan Project

Jalankan server development Laravel.

```bash
php artisan serve
```

Buka browser.

```
http://127.0.0.1:8000
```

Jika berhasil maka akan muncul halaman welcome Laravel.

---

# Membuka Project

Buka project menggunakan Visual Studio Code.

```bash
code .
```

---

# Struktur Folder Laravel

Berikut struktur folder utama Laravel yang akan sering digunakan.

```text
bookstore

app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
vendor/
```

Penjelasan singkat:

| Folder    | Fungsi                           |
| --------- | -------------------------------- |
| app       | Source Code Aplikasi             |
| config    | Konfigurasi Laravel              |
| database  | Migration, Seeder, Factory       |
| public    | Asset yang dapat diakses browser |
| resources | Blade View, CSS, JavaScript      |
| routes    | Routing Aplikasi                 |
| storage   | File Upload dan Log              |

---

# Konfigurasi Database

Buka file

```text
.env
```

Ubah konfigurasi database.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookstore
DB_USERNAME=root
DB_PASSWORD=
```

---

# Membuat Database

Masuk ke MySQL kemudian buat database.

```sql
CREATE DATABASE bookstore;
```

---

# Generate Application Key

Jalankan perintah berikut.

```bash
php artisan key:generate
```

---

# Menjalankan Migration Awal

Laravel sudah menyediakan migration bawaan.

Jalankan:

```bash
php artisan migrate
```

Database akan otomatis membuat beberapa tabel default.

* users
* password_reset_tokens
* sessions

---

# Menjalankan Vite

Laravel menggunakan Vite untuk asset frontend.

Install dependency.

```bash
npm install
```

Kemudian jalankan.

```bash
npm run dev
```

Biarkan terminal ini tetap berjalan selama proses development.

---

# Struktur Branch Git

Sebelum mulai membuat fitur, lakukan inisialisasi Git.

```bash
git init
```

Tambahkan seluruh file.

```bash
git add .
```

Commit pertama.

```bash
git commit -m "Initial commit Laravel 12"
```

---

# Struktur Folder yang Akan Digunakan

Selama project berlangsung kita akan menggunakan struktur berikut.

```text
app
├── Http
├── Models
├── Services
├── Providers

resources
├── views
│   ├── layouts
│   ├── partials
│   ├── public
│   ├── customer
│   └── admin

routes
├── web.php
├── admin.php
├── customer.php
├── auth.php
```

> Beberapa folder akan dibuat secara bertahap sesuai kebutuhan modul berikutnya.

---

# Konvensi Penamaan

Agar project mudah dipelihara, gunakan aturan berikut.

## Nama Class

Gunakan PascalCase.

Contoh:

```text
BookController
CategoryController
OrderService
```

---

## Nama File View

Gunakan snake_case.

Contoh:

```text
index.blade.php
create.blade.php
edit.blade.php
show.blade.php
```

---

## Nama Route

Gunakan format berikut.

```text
books.index

books.create

books.store

books.edit

books.update

books.destroy
```

---

## Nama Tabel

Gunakan bentuk jamak.

Contoh:

```text
books

categories

orders

customers
```

---

## Nama Model

Gunakan bentuk tunggal.

Contoh:

```text
Book

Category

Order

Customer
```

---

# Struktur Pengembangan

Project akan dikembangkan secara bertahap.

```text
Setup Project

↓

Authentication

↓

Role & Permission

↓

Bootstrap Layout

↓

Public Website

↓

Customer Module

↓

Admin Dashboard

↓

Master Data

↓

Shopping Cart

↓

Checkout

↓

Manual Payment

↓

Reports

↓

Deployment
```

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Laravel berhasil diinstall.
* [ ] Database berhasil dibuat.
* [ ] File `.env` telah dikonfigurasi.
* [ ] Migration berhasil dijalankan.
* [ ] Project dapat diakses melalui browser.
* [ ] Vite berhasil dijalankan.
* [ ] Git telah diinisialisasi.
* [ ] Initial Commit berhasil dibuat.

---

# Hasil Akhir Tahap

Apabila seluruh langkah telah selesai, maka project memiliki kondisi berikut:

* Laravel 12 berhasil berjalan.
* Database telah terhubung.
* Migration bawaan berhasil dijalankan.
* Project siap dikembangkan.
* Struktur project sudah dipahami.
* Version Control Git telah siap digunakan.

---

# Tahap Selanjutnya

Pada modul berikutnya kita akan mengimplementasikan **Authentication menggunakan Laravel Breeze** sebagai dasar sistem login sebelum membangun fitur Public Website, Customer Area, dan Admin Dashboard.
