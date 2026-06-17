# 10 - Master Supplier

# 🚚 Membangun Master Supplier

Master Supplier merupakan fitur yang digunakan untuk mengelola data pemasok buku. Supplier adalah pihak yang menyediakan buku kepada toko sehingga data supplier perlu disimpan sebagai referensi administrasi.

Pada modul ini akan dibuat fitur CRUD Supplier lengkap menggunakan Laravel Resource Controller, Validation, Pagination, Searching, dan Soft Delete.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat Migration Supplier
* Membuat Model Supplier
* Membuat Resource Controller
* Membuat CRUD Supplier
* Membuat Validasi Form
* Menggunakan Pagination
* Menggunakan Searching
* Menggunakan Soft Delete

---

# Konsep Supplier

Supplier merupakan perusahaan atau individu yang memasok buku ke toko.

Hubungan data.

```text
Supplier

↓

Buku (Opsional)

↓

Pengadaan Buku (Pengembangan)
```

Pada project ini relasi Supplier ke Buku bersifat opsional dan disiapkan untuk pengembangan selanjutnya.

---

# Struktur Database

Tabel:

```text
suppliers
```

Kolom yang digunakan.

| Field          | Tipe         |
| -------------- | ------------ |
| id             | bigint       |
| code           | varchar(20)  |
| name           | varchar(150) |
| contact_person | varchar(100) |
| phone          | varchar(20)  |
| email          | varchar(100) |
| address        | text         |
| city           | varchar(100) |
| status         | boolean      |
| created_at     | timestamp    |
| updated_at     | timestamp    |
| deleted_at     | timestamp    |

---

# Migration

Migration digunakan untuk membuat struktur tabel supplier.

Tahapan:

* Membuat migration
* Menambahkan field supplier
* Menambahkan soft delete
* Menjalankan migrate

---

# Model Supplier

Lokasi model.

```text
app
└── Models
    └── Supplier.php
```

Gunakan:

* HasFactory
* SoftDeletes
* Fillable

---

# Struktur Folder

```text
app
├── Models
│   └── Supplier.php
│
├── Http
│   └── Controllers
│       └── Admin
│           └── SupplierController.php
│
resources
└── views
    └── admin
        └── suppliers
            ├── index.blade.php
            ├── create.blade.php
            ├── edit.blade.php
            └── show.blade.php
```

---

# Resource Controller

Gunakan Resource Controller.

| Method  | Fungsi           |
| ------- | ---------------- |
| index   | Menampilkan data |
| create  | Form tambah      |
| store   | Simpan data      |
| show    | Detail supplier  |
| edit    | Form edit        |
| update  | Update data      |
| destroy | Hapus data       |

---

# Routing

Tambahkan Resource Route pada file:

```text
routes/admin.php
```

URL utama.

```text
/admin/suppliers
```

---

# Halaman Index

Halaman utama supplier menggunakan Bootstrap Table.

Kolom yang ditampilkan.

* No
* Kode Supplier
* Nama Supplier
* Contact Person
* Nomor Telepon
* Kota
* Status
* Aksi

---

# Form Tambah Supplier

Field yang digunakan.

* Kode Supplier
* Nama Supplier
* Contact Person
* Nomor Telepon
* Email
* Kota
* Alamat
* Status

Kode supplier dapat dibuat otomatis, misalnya:

```text
SUP-0001
SUP-0002
SUP-0003
```

---

# Halaman Detail

Informasi yang ditampilkan.

* Kode Supplier
* Nama Supplier
* Contact Person
* Nomor Telepon
* Email
* Kota
* Alamat
* Status
* Tanggal Dibuat

---

# Validasi

Gunakan Laravel Validation.

| Field          | Rule             |
| -------------- | ---------------- |
| code           | required, unique |
| name           | required         |
| contact_person | required         |
| phone          | required         |
| email          | nullable, email  |
| city           | required         |
| address        | required         |
| status         | required         |

---

# Searching

Pencarian berdasarkan.

* Nama Supplier
* Kode Supplier
* Kota
* Contact Person

---

# Pagination

Gunakan Pagination Laravel.

Jumlah data.

```text
10 Data
```

---

# Soft Delete

Supplier tidak dihapus permanen.

Keuntungan.

* Data pemasok tetap tersimpan.
* Riwayat administrasi tetap aman.
* Memudahkan proses audit.

---

# Seeder

Buat Seeder untuk data awal.

Contoh data.

* PT Gramedia Pustaka Utama
* Erlangga
* Andi Publisher
* Informatika Bandung
* Deepublish
* Elex Media Komputindo
* Mizan Media Utama
* Bumi Aksara

Minimal isi 8–10 supplier sebagai data awal aplikasi.

---

# Integrasi dengan Master Buku

Sebagai pengembangan, tambahkan field `supplier_id` pada tabel `books` sehingga setiap buku dapat diketahui berasal dari supplier mana.

Relasi.

```text
Supplier

1

↓

∞

Book
```

Relasi ini bersifat opsional dan dapat diimplementasikan setelah CRUD Supplier selesai.

---

# Tampilan Tabel

Gunakan Bootstrap Table.

Kolom.

```text
No

Kode

Nama Supplier

Contact Person

Telepon

Kota

Status

Aksi
```

---

# Tombol Aksi

Setiap data memiliki tombol.

* Detail
* Edit
* Hapus

Gunakan Bootstrap Button dengan ikon agar lebih mudah dikenali.

---

# Flash Message

Gunakan Session Flash Message.

Contoh.

* Supplier berhasil ditambahkan.
* Supplier berhasil diperbarui.
* Supplier berhasil dihapus.

Gunakan Bootstrap Alert.

---

# Best Practice

Gunakan aturan berikut.

* Gunakan Resource Controller.
* Gunakan Resource Route.
* Gunakan Validation.
* Gunakan Soft Delete.
* Gunakan Pagination.
* Gunakan Searching.
* Hindari logika database pada Blade.
* Gunakan relasi Eloquent jika Supplier dihubungkan dengan Buku.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration selesai.
* [ ] Model Supplier selesai.
* [ ] Resource Controller selesai.
* [ ] CRUD Supplier selesai.
* [ ] Validation berjalan.
* [ ] Pagination berjalan.
* [ ] Searching berjalan.
* [ ] Soft Delete berjalan.
* [ ] Seeder Supplier dibuat.
* [ ] Menu Supplier muncul pada Dashboard Admin.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Tabel `suppliers`
* Model Supplier
* CRUD Supplier
* Validation
* Searching
* Pagination
* Soft Delete
* Seeder Supplier
* Menu Master Supplier pada Dashboard Admin
* Persiapan relasi Supplier dengan Buku

Modul ini melengkapi Master Data aplikasi sehingga sistem memiliki referensi pemasok buku yang dapat digunakan untuk pengembangan fitur pengadaan atau manajemen inventori di masa mendatang.

---

# Tahap Selanjutnya

Pada modul **11 - Keranjang Belanja (Shopping Cart)** kita akan mulai membangun proses transaksi dari sisi Customer. Modul ini mencakup penambahan buku ke keranjang, pengelolaan jumlah pembelian, penghapusan item, perhitungan subtotal dan total belanja, serta persiapan menuju proses Checkout.
