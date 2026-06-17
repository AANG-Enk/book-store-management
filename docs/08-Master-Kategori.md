# 08 - Master Kategori Buku

# 📚 Membangun Master Kategori Buku

Master Kategori merupakan data utama (Master Data) yang digunakan untuk mengelompokkan buku berdasarkan jenis atau topiknya. Setiap buku nantinya wajib memiliki satu kategori.

Pada modul ini akan dibuat fitur CRUD (Create, Read, Update, Delete) lengkap menggunakan Laravel Resource Controller dan Bootstrap 5.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat Migration
* Membuat Model
* Membuat Resource Controller
* Membuat CRUD Kategori
* Membuat Validasi Form
* Menggunakan Eloquent ORM
* Menggunakan Soft Delete
* Menghubungkan kategori dengan data buku

---

# Konsep Master Data

Master Data merupakan data yang menjadi referensi bagi data lainnya.

Relasi yang akan digunakan.

```text
Kategori

↓

Buku

↓

Transaksi
```

Satu kategori dapat memiliki banyak buku (One to Many).

---

# Struktur Database

Tabel yang akan dibuat.

```text
categories
```

Kolom yang digunakan.

| Field       | Tipe         |
| ----------- | ------------ |
| id          | bigint       |
| name        | varchar(100) |
| slug        | varchar(120) |
| description | text         |
| status      | boolean      |
| created_at  | timestamp    |
| updated_at  | timestamp    |
| deleted_at  | timestamp    |

---

# Migration

Migration digunakan untuk membuat struktur tabel pada database.

Langkah yang dilakukan.

* Membuat migration
* Menambahkan field
* Menambahkan soft delete
* Menjalankan migrate

---

# Model Category

Buat Model:

```text
app
└── Models
    └── Category.php
```

Model bertugas berkomunikasi dengan tabel `categories`.

Gunakan:

* HasFactory
* SoftDeletes
* Fillable

---

# Struktur Folder

```text
app
├── Models
│   └── Category.php
│
├── Http
│   └── Controllers
│       └── Admin
│           └── CategoryController.php
│
resources
└── views
    └── admin
        └── categories
            ├── index.blade.php
            ├── create.blade.php
            ├── edit.blade.php
            └── show.blade.php
```

---

# Resource Controller

Gunakan Resource Controller.

Method yang digunakan.

| Method  | Fungsi           |
| ------- | ---------------- |
| index   | Menampilkan data |
| create  | Form tambah      |
| store   | Simpan data      |
| show    | Detail data      |
| edit    | Form edit        |
| update  | Update data      |
| destroy | Hapus data       |

---

# Routing

Gunakan Resource Route.

Contoh.

```text
/categories
```

Seluruh route berada pada:

```text
routes/admin.php
```

---

# Halaman Index

Halaman utama kategori menampilkan seluruh data.

Kolom tabel.

* No
* Nama Kategori
* Slug
* Status
* Jumlah Buku
* Aksi

Gunakan Bootstrap Table.

---

# Halaman Tambah

Form tambah kategori terdiri dari.

* Nama Kategori
* Slug
* Deskripsi
* Status

Slug dapat diisi otomatis menggunakan JavaScript atau diinput manual.

---

# Halaman Edit

Halaman Edit digunakan untuk memperbarui data kategori.

Field yang ditampilkan sama dengan halaman tambah.

---

# Halaman Detail

Menampilkan informasi kategori.

Informasi.

* Nama
* Slug
* Deskripsi
* Status
* Jumlah Buku
* Tanggal Dibuat

---

# Validasi

Gunakan Laravel Validation.

Aturan validasi.

| Field       | Rule             |
| ----------- | ---------------- |
| name        | required         |
| slug        | required, unique |
| description | nullable         |
| status      | required         |

---

# Soft Delete

Kategori tidak langsung dihapus dari database.

Gunakan:

```text
SoftDeletes
```

Keuntungan.

* Data masih dapat dipulihkan.
* Riwayat data tetap tersimpan.
* Menghindari kehilangan data penting.

---

# Relasi Database

Satu kategori memiliki banyak buku.

```text
Category

↓

Book

One To Many
```

Relasi akan digunakan pada modul Master Buku.

---

# Tampilan Tabel

Gunakan Bootstrap Table.

Kolom.

```text
No

Nama

Slug

Status

Jumlah Buku

Aksi
```

---

# Tombol Aksi

Setiap data memiliki tombol.

* Detail
* Edit
* Hapus

Gunakan Button Bootstrap.

---

# Alert

Gunakan Session Flash Message.

Contoh.

* Data berhasil ditambahkan.
* Data berhasil diubah.
* Data berhasil dihapus.

Gunakan Bootstrap Alert.

---

# Pagination

Gunakan Pagination Laravel.

Jumlah data per halaman.

```text
10 Data
```

---

# Searching

Tambahkan fitur pencarian sederhana.

Cari berdasarkan.

* Nama Kategori
* Slug

Menggunakan Request Query.

---

# Sorting

Urutkan data berdasarkan.

* Nama
* Tanggal Dibuat

Fitur ini bersifat opsional tetapi direkomendasikan.

---

# Seeder

Buat Seeder untuk data awal.

Contoh data.

* Pemrograman
* Database
* Web Development
* Mobile Development
* Desain Grafis
* Jaringan Komputer
* Kecerdasan Buatan
* Bisnis
* Pendidikan
* Novel

Seeder digunakan untuk mempermudah pengujian aplikasi.

---

# Integrasi dengan Public Website

Pada modul ini, kategori yang telah dibuat mulai dapat ditampilkan pada halaman Home dan Katalog Buku sebagai daftar kategori. Data yang sebelumnya bersifat statis akan diganti menggunakan data dari database.

---

# Best Practice

Gunakan aturan berikut.

* Gunakan Resource Controller.
* Gunakan Resource Route.
* Gunakan Validation.
* Gunakan Soft Delete.
* Gunakan Pagination.
* Hindari Query Builder di Blade.
* Pisahkan logika bisnis pada Controller atau Service jika diperlukan.
* Gunakan Eloquent Relationship.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration selesai.
* [ ] Model Category selesai.
* [ ] Resource Controller selesai.
* [ ] CRUD berjalan.
* [ ] Validasi berjalan.
* [ ] Soft Delete berjalan.
* [ ] Pagination berjalan.
* [ ] Searching berjalan.
* [ ] Seeder dibuat.
* [ ] Data kategori tampil pada Public Website.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Tabel `categories`
* Model Category
* Resource Controller
* CRUD Kategori
* Validasi Form
* Soft Delete
* Pagination
* Searching
* Seeder Data Kategori
* Relasi awal dengan Master Buku
* Integrasi kategori pada halaman publik

Master Kategori menjadi dasar untuk pengelolaan data buku pada modul berikutnya.

---

# Tahap Selanjutnya

Pada modul **09 - Master Buku** kita akan membangun fitur inti aplikasi, yaitu CRUD Buku. Modul ini mencakup relasi dengan kategori, upload cover buku, pengelolaan stok, ISBN, harga, penulis, penerbit, slug otomatis, pencarian, filter kategori, serta integrasi data buku ke halaman Public Website dan Customer Area.
