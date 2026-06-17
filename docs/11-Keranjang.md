# 11 - Keranjang Belanja

# 🛒 Membangun Keranjang Belanja (Shopping Cart)

Keranjang Belanja merupakan fitur yang memungkinkan Customer menyimpan daftar buku yang akan dibeli sebelum melakukan proses Checkout.

Pada modul ini Customer dapat menambahkan buku ke keranjang, mengubah jumlah pembelian, menghapus buku, serta melihat total belanja secara otomatis.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat tabel Cart
* Membuat tabel Cart Item
* Membuat relasi User dan Buku
* Menambahkan buku ke keranjang
* Mengubah jumlah pembelian
* Menghapus item keranjang
* Menghitung subtotal dan total belanja
* Melakukan validasi stok

---

# Konsep Shopping Cart

Alur pembelian.

```text
Customer

↓

Pilih Buku

↓

Tambah ke Keranjang

↓

Update Jumlah

↓

Checkout
```

Keranjang hanya dimiliki oleh satu Customer.

---

# Struktur Database

Dibuat dua tabel.

```text
carts

cart_items
```

---

# Tabel carts

| Field      | Tipe      |
| ---------- | --------- |
| id         | bigint    |
| user_id    | bigint    |
| created_at | timestamp |
| updated_at | timestamp |

---

# Tabel cart_items

| Field      | Tipe      |
| ---------- | --------- |
| id         | bigint    |
| cart_id    | bigint    |
| book_id    | bigint    |
| quantity   | integer   |
| price      | decimal   |
| subtotal   | decimal   |
| created_at | timestamp |
| updated_at | timestamp |

---

# Relasi Database

```text
User

1

↓

∞

Cart

1

↓

∞

Cart Item

∞

↓

1

Book
```

---

# Model

Buat Model berikut.

```text
Cart.php

CartItem.php
```

---

# Struktur Folder

```text
app
├── Models
│   ├── Cart.php
│   └── CartItem.php
│
├── Http
│   └── Controllers
│       └── Customer
│           └── CartController.php
│
resources
└── views
    └── customer
        └── cart
            └── index.blade.php
```

---

# Routing

Route Customer.

```text
/customer/cart
```

Tambahkan route.

* Lihat Keranjang
* Tambah Buku
* Update Jumlah
* Hapus Buku
* Kosongkan Keranjang

---

# Menambah Buku

Saat Customer menekan tombol.

```text
Tambah ke Keranjang
```

Sistem melakukan proses.

* Cek Login
* Cek Buku Aktif
* Cek Stok
* Tambahkan ke Cart
* Jika sudah ada, tambah Quantity

---

# Validasi

Sebelum menyimpan.

Periksa.

* Buku tersedia
* Status aktif
* Stok mencukupi
* Customer login

---

# Update Quantity

Customer dapat.

* Menambah jumlah
* Mengurangi jumlah

Aturan.

Minimal.

```text
1
```

Maksimal.

```text
Jumlah Stok Buku
```

---

# Menghapus Item

Customer dapat menghapus satu item dari keranjang.

Gunakan konfirmasi Bootstrap Modal sebelum menghapus data.

---

# Mengosongkan Keranjang

Tambahkan tombol.

```text
Kosongkan Keranjang
```

Seluruh item pada keranjang dihapus tanpa menghapus data buku.

---

# Halaman Keranjang

Gunakan Bootstrap Table.

Kolom.

* Cover
* Judul
* Harga
* Jumlah
* Subtotal
* Aksi

---

# Ringkasan Belanja

Di sisi kanan halaman tampilkan ringkasan.

Informasi.

* Total Item
* Total Buku
* Total Harga

Contoh.

```text
3 Item

5 Buku

Rp450.000
```

Tambahkan tombol.

```text
Lanjut Checkout
```

---

# Perhitungan Subtotal

Rumus.

```text
Subtotal = Harga × Quantity
```

---

# Perhitungan Total

Rumus.

```text
Total = Σ Seluruh Subtotal
```

Belum menggunakan:

* Pajak
* Ongkir
* Diskon

---

# Empty Cart

Jika keranjang kosong.

Tampilkan.

* Ilustrasi kosong
* Pesan

```text
Keranjang masih kosong.
```

Serta tombol.

```text
Belanja Sekarang
```

---

# Badge Jumlah Keranjang

Pada Navbar Customer tampilkan Badge.

Contoh.

```text
Keranjang (3)
```

Jumlah akan berubah otomatis sesuai isi keranjang.

---

# Integrasi Public Website

Pada halaman Detail Buku dan Katalog Buku, tombol **Tambah ke Keranjang** hanya muncul jika Customer sudah login.

Guest akan diarahkan ke halaman Login terlebih dahulu.

---

# Flash Message

Gunakan Session Flash.

Contoh.

* Buku berhasil ditambahkan ke keranjang.
* Jumlah pembelian diperbarui.
* Buku dihapus dari keranjang.
* Keranjang berhasil dikosongkan.

---

# Best Practice

Gunakan aturan berikut.

* Jangan menyimpan harga dari tabel buku saat ditampilkan, tetapi simpan snapshot harga ke `cart_items` ketika item ditambahkan ke keranjang.
* Selalu validasi stok sebelum menambah atau mengubah jumlah.
* Gunakan relasi Eloquent.
* Pisahkan logika perhitungan total di Controller atau Service.
* Hindari query database pada Blade.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration Cart selesai.
* [ ] Migration Cart Item selesai.
* [ ] Model Cart selesai.
* [ ] Model Cart Item selesai.
* [ ] Relasi Database selesai.
* [ ] Tambah ke Keranjang berjalan.
* [ ] Update Quantity berjalan.
* [ ] Hapus Item berjalan.
* [ ] Kosongkan Keranjang berjalan.
* [ ] Perhitungan Total berjalan.
* [ ] Badge Keranjang berjalan.
* [ ] Validasi Stok berjalan.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Tabel `carts`
* Tabel `cart_items`
* Model Cart
* Model CartItem
* Relasi User ↔ Cart ↔ CartItem ↔ Book
* Fitur Tambah ke Keranjang
* Update Jumlah Pembelian
* Hapus Item Keranjang
* Kosongkan Keranjang
* Perhitungan Subtotal dan Total
* Badge Jumlah Keranjang
* Validasi Stok Buku

Keranjang Belanja menjadi dasar proses transaksi yang akan dilanjutkan pada tahap Checkout.

---

# Tahap Selanjutnya

Pada modul **12 - Checkout & Pembuatan Pesanan** kita akan membangun proses checkout. Modul ini mencakup pembuatan data pesanan (`orders` dan `order_items`), penyimpanan alamat pembeli, perhitungan total pembayaran, pembuatan nomor invoice otomatis, serta perubahan isi keranjang menjadi transaksi yang siap dibayar menggunakan metode transfer bank (manual).
