# 07 - Admin Dashboard

# 🛠️ Membangun Admin Dashboard

Admin Dashboard merupakan pusat pengelolaan seluruh sistem Toko Buku. Seluruh proses administrasi dilakukan melalui halaman ini, mulai dari mengelola master data, transaksi, pembayaran, hingga laporan.

Pada tahap ini kita akan membangun struktur Dashboard Administrator beserta layout, sidebar, navbar, dan halaman utama menggunakan Bootstrap 5. Data statistik yang ditampilkan masih berupa placeholder dan akan dihubungkan dengan database pada modul-modul berikutnya.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat Dashboard Administrator
* Membuat Layout Admin
* Membuat Sidebar Admin
* Membuat Navbar Admin
* Menggunakan Middleware Role Admin
* Membuat Struktur Menu Administrator
* Menyiapkan Dashboard Statistik

---

# Konsep Admin Dashboard

Admin Dashboard hanya dapat diakses oleh pengguna yang memiliki role **Administrator**.

Alur akses sebagai berikut.

```text
Login

↓

Role Admin

↓

Admin Dashboard

↓

Kelola Sistem
```

---

# Hak Akses Administrator

Administrator memiliki hak akses penuh terhadap seluruh sistem.

Fitur yang dapat diakses:

* Dashboard
* Master Kategori
* Master Buku
* Master Customer
* Master User
* Transaksi
* Pembayaran
* Laporan
* Pengaturan Sistem
* Profil Admin

---

# Struktur Folder

Seluruh halaman Administrator disimpan pada folder berikut.

```text
resources
└── views
    └── admin
        ├── dashboard
        │   └── index.blade.php
        ├── categories
        ├── books
        ├── customers
        ├── users
        ├── orders
        ├── payments
        ├── reports
        ├── settings
        └── profile
```

---

# Struktur Controller

Controller Administrator dipisahkan berdasarkan modul.

```text
app
└── Http
    └── Controllers
        └── Admin
            ├── DashboardController.php
            ├── CategoryController.php
            ├── BookController.php
            ├── CustomerController.php
            ├── UserController.php
            ├── OrderController.php
            ├── PaymentController.php
            ├── ReportController.php
            ├── SettingController.php
            └── ProfileController.php
```

---

# Routing Administrator

Seluruh route Administrator diletakkan pada file:

```text
routes/admin.php
```

Route menggunakan middleware berikut.

* auth
* role:admin

---

# Struktur Menu Sidebar

Sidebar Administrator terdiri dari beberapa kelompok menu.

```text
Dashboard

MASTER DATA
    Kategori Buku
    Buku
    Customer
    User

TRANSAKSI
    Pesanan
    Pembayaran

LAPORAN
    Laporan Penjualan

PENGATURAN
    Pengaturan Sistem
    Profil Admin

Logout
```

---

# Layout Administrator

Seluruh halaman menggunakan layout berikut.

```text
layouts/admin.blade.php
```

Komponen layout:

* Navbar
* Sidebar
* Breadcrumb
* Content
* Footer

---

# Navbar Administrator

Navbar menampilkan informasi berikut.

* Logo Aplikasi
* Judul Dashboard
* Notifikasi
* Nama Admin
* Dropdown Profil
* Logout

Notifikasi masih berupa tampilan dummy.

---

# Dashboard Administrator

Dashboard merupakan halaman pertama setelah Admin berhasil login.

Komponen yang ditampilkan:

* Statistik Sistem
* Grafik Penjualan (Placeholder)
* Buku Terbaru
* Pesanan Terbaru
* Customer Baru
* Aktivitas Sistem

---

# Statistik Dashboard

Gunakan Card Bootstrap.

Informasi yang ditampilkan.

| Card             | Keterangan       |
| ---------------- | ---------------- |
| Total Buku       | Jumlah Buku      |
| Total Customer   | Jumlah Pelanggan |
| Total Pesanan    | Jumlah Transaksi |
| Total Pendapatan | Total Penjualan  |

Seluruh data masih berupa placeholder.

---

# Shortcut Menu

Tambahkan menu cepat menuju halaman utama.

Contoh:

* Tambah Buku
* Tambah Kategori
* Data Customer
* Data Pesanan
* Data Pembayaran

Shortcut dibuat menggunakan Card Bootstrap atau Icon Card.

---

# Aktivitas Terbaru

Dashboard menampilkan aktivitas sistem.

Contoh data:

* Customer baru mendaftar
* Pesanan baru
* Pembayaran baru
* Buku baru ditambahkan

Data masih menggunakan dummy.

---

# Grafik Penjualan

Siapkan area grafik.

Grafik belum menggunakan data database.

Pada modul Laporan akan menggunakan Chart.js.

Sementara cukup dibuat placeholder.

---

# Breadcrumb

Setiap halaman Administrator menggunakan Breadcrumb.

Contoh.

```text
Dashboard

↓

Master Buku

↓

Tambah Buku
```

---

# Responsive Design

Dashboard harus tetap nyaman digunakan pada:

* Desktop
* Laptop
* Tablet

Untuk tampilan mobile, sidebar dapat dibuat menjadi Offcanvas Bootstrap.

---

# Struktur Navigasi

```text
Login

↓

Dashboard

↓

Master Data

↓

Transaksi

↓

Laporan

↓

Pengaturan
```

---

# Komponen Bootstrap

Komponen yang digunakan:

* Navbar
* Sidebar
* Card
* Table
* Badge
* Alert
* Dropdown
* Breadcrumb
* Modal
* Pagination
* Offcanvas
* Toast (Opsional)

---

# Best Practice

Gunakan aturan berikut.

* Pisahkan Controller berdasarkan modul.
* Gunakan middleware `auth` dan `role:admin`.
* Gunakan layout Admin untuk seluruh halaman.
* Hindari logika bisnis di Blade.
* Gunakan Bootstrap Card untuk statistik.
* Gunakan Badge untuk status transaksi.
* Gunakan Breadcrumb pada setiap halaman.
* Gunakan Sidebar yang konsisten di seluruh modul.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Layout Admin selesai.
* [ ] Sidebar selesai.
* [ ] Navbar selesai.
* [ ] Dashboard selesai.
* [ ] Statistik Dashboard dibuat.
* [ ] Shortcut Menu dibuat.
* [ ] Placeholder Grafik dibuat.
* [ ] Breadcrumb dibuat.
* [ ] Routing Admin berjalan.
* [ ] Middleware Admin berjalan.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Dashboard Administrator
* Layout Admin Bootstrap
* Sidebar Administrator
* Navbar Administrator
* Struktur Menu Admin
* Dashboard Statistik
* Placeholder Grafik Penjualan
* Struktur Controller Admin
* Routing Administrator
* Middleware Role Admin

Dashboard ini menjadi fondasi untuk seluruh modul CRUD yang akan dibangun pada tahap berikutnya.

---

# Tahap Selanjutnya

Pada modul **08 - Master Kategori Buku** kita akan mulai membangun fitur CRUD pertama. Modul ini mencakup pembuatan migration, model, controller, validasi, upload ikon (opsional), serta operasi Create, Read, Update, dan Delete untuk kategori buku yang nantinya akan digunakan sebagai relasi pada data buku.
