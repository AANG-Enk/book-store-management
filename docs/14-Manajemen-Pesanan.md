# 14 - Manajemen Pesanan

# 📦 Manajemen Pesanan (Order Management)

Setelah pembayaran berhasil diverifikasi, pesanan akan masuk ke proses pengelolaan oleh Admin. Pada modul ini Admin dapat mengubah status pesanan sesuai dengan proses bisnis toko buku, mulai dari pesanan diproses hingga selesai diterima oleh Customer.

Selain itu Customer dapat memantau perkembangan status pesanannya melalui halaman Riwayat Pesanan.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Mengelola daftar pesanan
* Mengubah status pesanan
* Menambahkan nomor resi pengiriman
* Menyimpan informasi ekspedisi
* Menampilkan timeline status pesanan
* Menampilkan riwayat pesanan Customer

---

# Konsep Order Management

Alur pesanan.

```text
Checkout

↓

Pembayaran

↓

Diproses

↓

Dikirim

↓

Selesai
```

Apabila pembayaran gagal.

```text
Pending

↓

Rejected

↓

Upload Ulang
```

Apabila pesanan dibatalkan.

```text
Pending

↓

Cancelled
```

---

# Status Pesanan

Gunakan Enum.

```text
Pending

Diproses

Dikirim

Selesai

Dibatalkan
```

Status hanya dapat berubah secara berurutan.

---

# Penambahan Kolom Orders

Tambahkan beberapa field pada tabel `orders`.

| Field           | Tipe                |
| --------------- | ------------------- |
| courier         | varchar (nullable)  |
| tracking_number | varchar (nullable)  |
| shipped_at      | datetime (nullable) |
| completed_at    | datetime (nullable) |
| cancelled_at    | datetime (nullable) |

Field ini digunakan untuk menyimpan informasi pengiriman dan penyelesaian pesanan.

---

# Struktur Folder

```text
app
├── Http
│   └── Controllers
│       ├── Admin
│       │   └── OrderController.php
│       │
│       └── Customer
│           └── OrderController.php
│
resources
└── views
    ├── admin
    │   └── orders
    │       ├── index.blade.php
    │       ├── show.blade.php
    │       └── edit.blade.php
    │
    └── customer
        └── orders
            ├── index.blade.php
            └── show.blade.php
```

---

# Dashboard Admin

Menu baru.

```text
Manajemen Pesanan
```

Halaman utama menampilkan seluruh transaksi.

Kolom.

* Invoice
* Customer
* Total
* Status Pembayaran
* Status Pesanan
* Tanggal
* Aksi

Gunakan Pagination dan Searching.

---

# Filter Data

Sediakan filter berdasarkan.

* Status Pembayaran
* Status Pesanan
* Tanggal
* Customer

Dengan filter ini Admin lebih mudah menemukan transaksi tertentu.

---

# Detail Pesanan

Admin dapat melihat informasi lengkap.

* Nomor Invoice
* Data Customer
* Alamat Pengiriman
* Daftar Buku
* Total Pembayaran
* Bukti Transfer
* Status Pembayaran
* Status Pesanan

---

# Update Status

Admin dapat mengubah status pesanan.

Urutan status.

```text
Pending

↓

Diproses

↓

Dikirim

↓

Selesai
```

Perubahan status dilakukan melalui tombol Bootstrap atau dropdown.

---

# Pengiriman Pesanan

Saat status menjadi **Dikirim**, Admin mengisi data berikut.

* Nama Ekspedisi
* Nomor Resi

Contoh.

```text
Ekspedisi

JNE

Resi

JNE123456789
```

Informasi ini akan tampil pada halaman Customer.

---

# Penyelesaian Pesanan

Jika pesanan telah diterima Customer.

Status.

```text
Selesai
```

Sistem mengisi otomatis.

* completed_at

Tanggal penyelesaian digunakan sebagai laporan transaksi selesai.

---

# Pembatalan Pesanan

Admin dapat membatalkan pesanan apabila.

* Pembayaran tidak dilakukan dalam batas waktu.
* Customer meminta pembatalan.
* Terjadi kesalahan stok.

Saat dibatalkan.

* Status Pesanan → Dibatalkan
* Isi `cancelled_at`
* Kembalikan stok buku ke jumlah semula apabila stok sudah dikurangi saat checkout.

---

# Timeline Pesanan

Pada halaman Detail Pesanan Customer tampilkan timeline.

Contoh.

```text
✓ Pesanan Dibuat

↓

✓ Menunggu Pembayaran

↓

✓ Pembayaran Diverifikasi

↓

✓ Diproses

↓

✓ Dikirim

↓

✓ Selesai
```

Gunakan komponen Bootstrap seperti List Group atau Progress.

---

# Halaman Customer

Menu.

```text
Pesanan Saya
```

Customer dapat melihat.

* Invoice
* Total
* Status Pembayaran
* Status Pesanan
* Nomor Resi (jika tersedia)
* Detail Pesanan

---

# Pencarian

Customer dapat mencari berdasarkan.

* Nomor Invoice
* Status Pesanan

---

# Flash Message

Contoh.

* Status pesanan berhasil diperbarui.
* Nomor resi berhasil disimpan.
* Pesanan berhasil diselesaikan.
* Pesanan berhasil dibatalkan.

Gunakan Bootstrap Alert.

---

# Dashboard Admin

Tambahkan beberapa Card.

```text
Pesanan Baru

Pesanan Diproses

Pesanan Dikirim

Pesanan Selesai
```

Jumlah setiap card diperbarui secara otomatis berdasarkan data transaksi.

---

# Dashboard Customer

Pada halaman Dashboard Customer tampilkan ringkasan.

* Total Pesanan
* Menunggu Pembayaran
* Sedang Diproses
* Sedang Dikirim
* Pesanan Selesai

---

# Best Practice

Gunakan aturan berikut.

* Gunakan Enum atau konstanta untuk status pesanan.
* Validasi perubahan status agar tidak meloncat urutan.
* Simpan tanggal setiap perubahan status penting.
* Kembalikan stok ketika pesanan dibatalkan.
* Gunakan Eloquent Relationship.
* Pisahkan logika perubahan status dari tampilan.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Halaman Manajemen Pesanan selesai.
* [ ] Daftar Pesanan tampil.
* [ ] Detail Pesanan selesai.
* [ ] Update Status berjalan.
* [ ] Pengisian Resi berjalan.
* [ ] Timeline Pesanan tampil.
* [ ] Riwayat Pesanan Customer selesai.
* [ ] Filter Data berjalan.
* [ ] Searching berjalan.
* [ ] Pembatalan Pesanan mengembalikan stok.
* [ ] Dashboard menampilkan statistik pesanan.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Manajemen Pesanan oleh Admin
* Riwayat Pesanan Customer
* Update Status Pesanan
* Informasi Pengiriman dan Nomor Resi
* Timeline Proses Pesanan
* Pembatalan Pesanan
* Pengembalian Stok saat pembatalan
* Statistik Pesanan pada Dashboard

Dengan selesainya modul ini, seluruh siklus transaksi dari checkout hingga pesanan selesai telah dapat dikelola oleh sistem.

---

# Tahap Selanjutnya

Pada modul **15 - Laporan & Dashboard Statistik**, kita akan membangun halaman laporan untuk Admin yang meliputi laporan penjualan, laporan stok buku, laporan pelanggan, laporan pembayaran, grafik penjualan, serta fitur cetak dan ekspor data sebagai penutup dari keseluruhan Sistem Informasi Toko Buku.
