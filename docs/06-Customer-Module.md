# 06 - Customer Module

# 👤 Membangun Customer Area

Customer Area merupakan halaman khusus yang hanya dapat diakses oleh pengguna yang telah login sebagai **Customer**.

Area ini menjadi pusat aktivitas pelanggan, mulai dari melihat dashboard, mengelola profil, melihat katalog buku, hingga melakukan transaksi pembelian.

Pada tahap ini kita akan membangun struktur Customer Area beserta halaman dashboard dan navigasinya. Fitur transaksi seperti Keranjang, Checkout, dan Riwayat Pesanan masih berupa halaman persiapan (placeholder) dan akan disempurnakan pada modul berikutnya.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat Dashboard Customer
* Membuat Layout Customer
* Membuat Sidebar Customer
* Membuat Routing Customer
* Menggunakan Middleware Role
* Membuat Struktur View Customer
* Menyiapkan halaman transaksi

---

# Konsep Customer Area

Customer Area hanya dapat diakses setelah pengguna berhasil login sebagai **Customer**.

Alur akses sebagai berikut.

```text
Guest

↓

Login

↓

Role Customer

↓

Customer Dashboard

↓

Menu Customer
```

---

# Hak Akses Customer

Customer memiliki hak akses terhadap fitur berikut.

* Dashboard
* Profil
* Katalog Buku
* Keranjang
* Checkout
* Riwayat Pesanan
* Detail Pesanan
* Upload Bukti Pembayaran

Customer **tidak memiliki akses** ke halaman Administrator.

---

# Struktur Folder

Seluruh halaman Customer disimpan pada folder berikut.

```text
resources
└── views
    └── customer
        ├── dashboard
        │   └── index.blade.php
        ├── profile
        │   └── index.blade.php
        ├── books
        │   └── index.blade.php
        ├── cart
        │   └── index.blade.php
        ├── checkout
        │   └── index.blade.php
        ├── orders
        │   ├── index.blade.php
        │   └── show.blade.php
        └── payments
            └── upload.blade.php
```

---

# Struktur Controller

Buat controller khusus Customer.

```text
app
└── Http
    └── Controllers
        └── Customer
            ├── DashboardController.php
            ├── ProfileController.php
            ├── BookController.php
            ├── CartController.php
            ├── CheckoutController.php
            ├── OrderController.php
            └── PaymentController.php
```

Meskipun beberapa controller belum digunakan sepenuhnya, struktur ini akan memudahkan pengembangan pada modul berikutnya.

---

# Routing Customer

Seluruh route Customer diletakkan pada file:

```text
routes/customer.php
```

Route menggunakan middleware berikut.

* auth
* role:customer

Contoh struktur route.

| URL                 | Halaman         |
| ------------------- | --------------- |
| /customer/dashboard | Dashboard       |
| /customer/profile   | Profil          |
| /customer/books     | Katalog Buku    |
| /customer/cart      | Keranjang       |
| /customer/checkout  | Checkout        |
| /customer/orders    | Riwayat Pesanan |

---

# Dashboard Customer

Dashboard menjadi halaman pertama setelah Customer berhasil login.

Komponen yang ditampilkan:

* Ucapan Selamat Datang
* Informasi Akun
* Ringkasan Pesanan
* Ringkasan Keranjang
* Ringkasan Pembayaran
* Buku Terbaru
* Shortcut Menu

Pada tahap ini data masih berupa placeholder.

---

# Kartu Informasi Dashboard

Dashboard menggunakan Card Bootstrap.

Contoh informasi:

* Total Pesanan
* Pesanan Diproses
* Menunggu Pembayaran
* Pesanan Selesai

Seluruh data akan dihubungkan dengan database pada modul transaksi.

---

# Sidebar Customer

Sidebar memudahkan pelanggan berpindah antar menu.

Struktur menu.

```text
Dashboard

Katalog Buku

Keranjang

Checkout

Riwayat Pesanan

Profil

Logout
```

---

# Halaman Profil

Halaman profil digunakan untuk menampilkan informasi akun.

Informasi yang ditampilkan:

* Nama
* Email
* Nomor Telepon
* Alamat
* Foto Profil (Opsional)

Fitur edit profil akan dibahas pada modul Profile.

---

# Halaman Katalog Buku

Customer tetap dapat melihat katalog buku dari dalam Dashboard.

Perbedaannya dengan Public Website adalah nantinya Customer dapat:

* Menambahkan buku ke Keranjang
* Membeli buku
* Melihat status stok

---

# Halaman Keranjang

Pada tahap ini dibuat sebagai halaman persiapan.

Komponen:

* Daftar Buku
* Jumlah
* Harga
* Total Belanja
* Tombol Checkout

Logika keranjang akan dibangun pada modul **11 - Keranjang**.

---

# Halaman Checkout

Halaman Checkout juga masih berupa persiapan.

Komponen:

* Daftar Belanja
* Alamat Pengiriman
* Metode Pembayaran
* Ringkasan Pembayaran

Implementasi lengkap dibahas pada modul **12 - Checkout**.

---

# Halaman Riwayat Pesanan

Customer dapat melihat seluruh transaksi yang pernah dilakukan.

Kolom yang akan ditampilkan:

* Nomor Pesanan
* Tanggal
* Total
* Status
* Detail

Data masih berupa placeholder.

---

# Status Pesanan

Status transaksi menggunakan Badge Bootstrap.

Status yang digunakan:

| Status    | Keterangan              |
| --------- | ----------------------- |
| Pending   | Menunggu Pembayaran     |
| Paid      | Sudah Dibayar           |
| Verified  | Pembayaran Diverifikasi |
| Process   | Sedang Diproses         |
| Completed | Pesanan Selesai         |
| Cancelled | Pesanan Dibatalkan      |

---

# Layout Customer

Seluruh halaman Customer menggunakan:

```text
layouts/customer.blade.php
```

Layout terdiri dari:

* Navbar
* Sidebar
* Breadcrumb
* Content
* Footer

---

# Best Practice

Selama membangun Customer Area gunakan aturan berikut.

* Pisahkan controller sesuai tanggung jawab.
* Gunakan middleware `auth` dan `role`.
* Gunakan layout Customer untuk seluruh halaman.
* Gunakan Card Bootstrap pada Dashboard.
* Gunakan Badge Bootstrap untuk status transaksi.
* Hindari logika bisnis pada file Blade.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Layout Customer selesai.
* [ ] Dashboard Customer selesai.
* [ ] Sidebar Customer selesai.
* [ ] Routing Customer selesai.
* [ ] Middleware Customer berjalan.
* [ ] Halaman Profil dibuat.
* [ ] Halaman Katalog dibuat.
* [ ] Halaman Keranjang dibuat.
* [ ] Halaman Checkout dibuat.
* [ ] Halaman Riwayat Pesanan dibuat.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Customer Dashboard
* Layout Customer
* Sidebar Customer
* Routing Customer
* Struktur Controller Customer
* Struktur View Customer
* Halaman Profil
* Halaman Keranjang (Placeholder)
* Halaman Checkout (Placeholder)
* Halaman Riwayat Pesanan (Placeholder)

Dengan fondasi ini, seluruh fitur transaksi dapat dibangun secara bertahap tanpa mengubah struktur aplikasi.

---

# Tahap Selanjutnya

Pada modul **07 - Admin Dashboard** kita akan membangun area Administrator sebagai pusat pengelolaan sistem. Modul ini mencakup Dashboard Admin, menu navigasi, statistik, kartu informasi, notifikasi transaksi, serta struktur halaman yang akan digunakan untuk mengelola seluruh master data dan transaksi pada modul-modul berikutnya.
