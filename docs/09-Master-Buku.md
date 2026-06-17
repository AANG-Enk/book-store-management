# 09 - Master Buku

# 📖 Membangun Master Buku

Master Buku merupakan fitur inti pada aplikasi Toko Buku. Seluruh data buku yang akan ditampilkan pada halaman Public Website, Customer Area, hingga proses transaksi berasal dari modul ini.

Pada modul ini akan dibangun fitur CRUD Buku lengkap menggunakan Laravel Resource Controller, Eloquent ORM, Relasi Database, Upload Cover Buku, Validasi, Pencarian, Filter, Pagination, dan Soft Delete.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat Migration Buku
* Membuat Model Buku
* Membuat Relasi dengan Kategori
* Membuat CRUD Buku
* Upload Cover Buku
* Menggunakan Validation
* Menggunakan Eloquent Relationship
* Menggunakan Pagination
* Menggunakan Searching
* Menggunakan Filtering
* Menggunakan Soft Delete

---

# Konsep Data Buku

Setiap buku harus memiliki satu kategori.

Relasi database.

```text
Kategori

↓

Buku

↓

Detail Pesanan
```

Satu kategori dapat memiliki banyak buku.

---

# Struktur Database

Tabel:

```text
books
```

Kolom yang digunakan.

| Field        | Tipe         |
| ------------ | ------------ |
| id           | bigint       |
| category_id  | bigint       |
| title        | varchar(200) |
| slug         | varchar(220) |
| isbn         | varchar(30)  |
| author       | varchar(150) |
| publisher    | varchar(150) |
| publish_year | year         |
| pages        | integer      |
| stock        | integer      |
| price        | decimal      |
| cover        | varchar      |
| description  | longtext     |
| status       | boolean      |
| created_at   | timestamp    |
| updated_at   | timestamp    |
| deleted_at   | timestamp    |

---

# Migration

Migration bertugas membuat struktur tabel buku.

Tahapan:

* Membuat migration
* Menambahkan foreign key kategori
* Menambahkan soft delete
* Menjalankan migrate

---

# Relasi Database

Relasi yang digunakan.

```text
Category

1

↓

∞

Book
```

Pada Model.

Category

```text
hasMany(Book)
```

Book

```text
belongsTo(Category)
```

---

# Model Book

Lokasi Model.

```text
app
└── Models
    └── Book.php
```

Gunakan.

* HasFactory
* SoftDeletes
* Fillable
* Relationship

---

# Struktur Folder

```text
app
├── Models
│   └── Book.php
│
├── Http
│   └── Controllers
│       └── Admin
│           └── BookController.php
│
resources
└── views
    └── admin
        └── books
            ├── index.blade.php
            ├── create.blade.php
            ├── edit.blade.php
            └── show.blade.php
```

---

# Resource Controller

Gunakan Resource Controller.

Method.

| Method  | Fungsi      |
| ------- | ----------- |
| index   | Daftar Buku |
| create  | Form Tambah |
| store   | Simpan Buku |
| show    | Detail Buku |
| edit    | Form Edit   |
| update  | Update Buku |
| destroy | Hapus Buku  |

---

# Form Tambah Buku

Field yang digunakan.

* Kategori
* Judul Buku
* Slug
* ISBN
* Penulis
* Penerbit
* Tahun Terbit
* Jumlah Halaman
* Harga
* Stok
* Cover Buku
* Deskripsi
* Status

---

# Upload Cover Buku

Gunakan Laravel Storage.

Folder penyimpanan.

```text
storage/app/public/books
```

Ketentuan.

* Format JPG
* JPEG
* PNG

Ukuran maksimal.

```text
2 MB
```

Jika cover diubah, file lama sebaiknya dihapus agar penyimpanan tetap rapi.

---

# Slug

Slug digunakan untuk URL.

Contoh.

```text
Laravel Untuk Pemula

↓

laravel-untuk-pemula
```

Slug dapat dibuat otomatis menggunakan JavaScript atau helper Laravel.

---

# Halaman Index

Gunakan Bootstrap Table.

Kolom.

* No
* Cover
* Judul
* Kategori
* Penulis
* Harga
* Stok
* Status
* Aksi

---

# Halaman Detail

Menampilkan informasi lengkap buku.

Informasi.

* Cover
* Judul
* ISBN
* Penulis
* Penerbit
* Tahun
* Jumlah Halaman
* Harga
* Stok
* Kategori
* Deskripsi

---

# Validasi

Gunakan Laravel Validation.

| Field        | Rule              |
| ------------ | ----------------- |
| category_id  | required          |
| title        | required          |
| slug         | required, unique  |
| isbn         | required          |
| author       | required          |
| publisher    | required          |
| publish_year | required          |
| pages        | required, integer |
| stock        | required, integer |
| price        | required, numeric |
| cover        | image             |
| description  | required          |
| status       | required          |

---

# Searching

Pencarian berdasarkan.

* Judul
* Penulis
* ISBN

Gunakan Request Query.

---

# Filter

Tambahkan filter.

* Kategori
* Status

Filter dapat dikombinasikan dengan fitur pencarian.

---

# Sorting

Urutkan berdasarkan.

* Judul
* Harga
* Stok
* Tanggal Dibuat

Opsional.

---

# Pagination

Gunakan Pagination Laravel.

Jumlah data.

```text
10 Data
```

---

# Soft Delete

Gunakan Soft Delete.

Keuntungan.

* Data tidak hilang permanen.
* Dapat dipulihkan.
* Aman untuk transaksi yang sudah pernah terjadi.

---

# Seeder Buku

Buat Seeder.

Minimal.

```text
20 Buku
```

Gunakan kategori yang telah dibuat sebelumnya.

Contoh.

* Laravel Dasar
* Belajar PHP
* Clean Code
* Database MySQL
* UI UX Design
* Machine Learning
* Algoritma
* Pemrograman Web
* Python Fundamental
* Java OOP

---

# Integrasi Public Website

Setelah CRUD selesai, halaman Public Website mulai menggunakan data dari database.

Halaman yang diperbarui.

* Home
* Katalog Buku
* Detail Buku

Fitur.

* Menampilkan Cover
* Menampilkan Harga
* Menampilkan Penulis
* Menampilkan Kategori
* Menampilkan Buku Terbaru

---

# Integrasi Customer

Customer dapat melihat seluruh buku dari database.

Tahap ini hanya menampilkan data.

Fitur pembelian akan dibuat pada modul Keranjang.

---

# Status Buku

Gunakan Badge Bootstrap.

Status.

| Status      | Warna   |
| ----------- | ------- |
| Aktif       | Hijau   |
| Tidak Aktif | Abu-abu |
| Stok Habis  | Merah   |

Status stok habis dapat ditampilkan otomatis ketika jumlah stok bernilai nol.

---

# Tombol Aksi

Setiap data memiliki tombol.

* Detail
* Edit
* Hapus

Gunakan Bootstrap Button.

---

# Flash Message

Gunakan Session Flash.

Contoh.

* Buku berhasil ditambahkan.
* Buku berhasil diubah.
* Buku berhasil dihapus.

Gunakan Bootstrap Alert.

---

# Best Practice

Gunakan aturan berikut.

* Gunakan Resource Controller.
* Gunakan Eloquent Relationship.
* Simpan gambar menggunakan Storage.
* Jangan menyimpan gambar di folder public secara langsung.
* Gunakan Soft Delete.
* Gunakan Pagination.
* Pisahkan validasi menggunakan Form Request (opsional).
* Hindari logika database di Blade.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration selesai.
* [ ] Model Book selesai.
* [ ] Relasi Category selesai.
* [ ] CRUD Buku selesai.
* [ ] Upload Cover berjalan.
* [ ] Validation berjalan.
* [ ] Pagination berjalan.
* [ ] Searching berjalan.
* [ ] Filter berjalan.
* [ ] Soft Delete berjalan.
* [ ] Seeder Buku dibuat.
* [ ] Data tampil pada Public Website.
* [ ] Data tampil pada Customer Area.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Tabel `books`
* Model Book
* Relasi Category ↔ Book
* CRUD Buku lengkap
* Upload Cover Buku
* Validasi Form
* Searching
* Filter Kategori
* Pagination
* Soft Delete
* Seeder Data Buku
* Integrasi dengan Public Website
* Integrasi dengan Customer Area

Master Buku menjadi sumber utama data yang akan digunakan pada seluruh proses transaksi, mulai dari Keranjang hingga Laporan Penjualan.

---

# Tahap Selanjutnya

Pada modul **10 - Master Customer & User Management** kita akan membangun pengelolaan data pengguna. Modul ini mencakup daftar customer, detail akun, status aktif/nonaktif, pengelolaan user administrator, reset password sederhana, serta monitoring aktivitas pengguna yang telah terdaftar pada sistem.
