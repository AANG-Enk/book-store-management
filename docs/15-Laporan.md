# 15 - Laporan

# 📊 Laporan & Dashboard Statistik

Modul Laporan merupakan tahap akhir dari pembangunan Sistem Informasi Toko Buku. Pada modul ini Admin dapat melihat berbagai laporan transaksi, stok buku, pelanggan, serta statistik penjualan dalam bentuk tabel dan grafik.

Laporan juga dapat dicetak ke PDF maupun diekspor ke Excel sebagai dokumen administrasi.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat Dashboard Statistik
* Membuat Laporan Penjualan
* Membuat Laporan Pembayaran
* Membuat Laporan Buku
* Membuat Laporan Pelanggan
* Membuat Grafik Penjualan
* Export PDF
* Export Excel

---

# Konsep Dashboard

Dashboard digunakan untuk memberikan ringkasan kondisi toko secara cepat.

Informasi yang ditampilkan.

```text
Total Buku

Total Customer

Total Pesanan

Total Penjualan
```

Serta grafik penjualan.

---

# Struktur Folder

```text
app
├── Exports
│   ├── SalesExport.php
│   ├── BooksExport.php
│   └── CustomersExport.php
│
├── Http
│   └── Controllers
│       └── Admin
│           ├── DashboardController.php
│           └── ReportController.php
│
resources
└── views
    └── admin
        ├── dashboard
        │   └── index.blade.php
        │
        └── reports
            ├── sales.blade.php
            ├── books.blade.php
            ├── customers.blade.php
            ├── payments.blade.php
            └── stock.blade.php
```

---

# Dashboard Admin

Gunakan Bootstrap Card.

Card yang ditampilkan.

* Total Buku
* Total Kategori
* Total Supplier
* Total Customer
* Total Pesanan
* Total Penjualan
* Pembayaran Pending
* Stok Hampir Habis

Semua data dihitung secara realtime dari database.

---

# Grafik Penjualan

Gunakan Chart.js.

Grafik.

```text
Penjualan Bulanan
```

Sumbu X.

```text
Januari

Februari

...

Desember
```

Sumbu Y.

```text
Total Penjualan
```

Grafik diambil dari data transaksi dengan status pembayaran **Paid**.

---

# Grafik Buku Terlaris

Tambahkan grafik kedua.

```text
Top 10 Buku Terlaris
```

Data berdasarkan total quantity yang terjual.

---

# Laporan Penjualan

Menu.

```text
Laporan Penjualan
```

Kolom.

* Invoice
* Customer
* Tanggal
* Total
* Status Pembayaran
* Status Pesanan

Tambahkan filter.

* Tanggal Awal
* Tanggal Akhir
* Status Pembayaran

---

# Laporan Pembayaran

Kolom.

* Invoice
* Customer
* Nominal
* Bank
* Status
* Tanggal Transfer

Tambahkan filter tanggal.

---

# Laporan Buku

Kolom.

* Kode Buku
* Judul
* Kategori
* Supplier
* Harga
* Stok

Tambahkan pencarian berdasarkan judul dan kategori.

---

# Laporan Stok Buku

Kolom.

* Judul Buku
* Stok Saat Ini
* Minimal Stok

Berikan tanda khusus untuk stok rendah.

Contoh.

```text
Stok < 5

Badge Merah
```

---

# Laporan Customer

Kolom.

* Nama
* Email
* Nomor Telepon
* Total Pesanan
* Total Belanja

Urutkan berdasarkan total belanja terbesar.

---

# Filter Laporan

Semua laporan mendukung filter.

* Tanggal
* Bulan
* Tahun
* Customer
* Status

Gunakan Form Bootstrap.

---

# Export Excel

Gunakan package.

```text
Laravel Excel
```

Laporan yang dapat diekspor.

* Penjualan
* Buku
* Customer

Nama file.

```text
laporan-penjualan.xlsx

laporan-buku.xlsx

laporan-customer.xlsx
```

---

# Export PDF

Gunakan package.

```text
Laravel DomPDF
```

Laporan yang dapat dicetak.

* Penjualan
* Pembayaran
* Buku

Ukuran kertas.

```text
A4
```

Orientasi.

```text
Portrait
```

Untuk laporan yang memiliki banyak kolom dapat menggunakan.

```text
Landscape
```

---

# Dashboard Customer

Tambahkan Dashboard sederhana.

Informasi.

* Total Pesanan
* Total Belanja
* Pesanan Diproses
* Pesanan Dikirim
* Pesanan Selesai

Customer juga dapat melihat daftar transaksi terakhir.

---

# Statistik Tambahan

Tambahkan beberapa informasi.

* Buku Terlaris
* Customer Teraktif
* Penjualan Hari Ini
* Penjualan Bulan Ini

---

# Dashboard Publik

Halaman utama website dapat menampilkan.

* Jumlah Buku
* Jumlah Kategori
* Buku Terbaru
* Buku Terlaris

Informasi ini bersifat informatif untuk pengunjung.

---

# Flash Message

Gunakan Bootstrap Alert.

Contoh.

* Export berhasil.
* Data tidak ditemukan.
* Laporan berhasil dicetak.

---

# Best Practice

Gunakan aturan berikut.

* Gunakan Query Builder atau Eloquent Aggregate untuk laporan.
* Hindari query berulang (N+1 Query).
* Gunakan Pagination pada laporan.
* Gunakan eager loading untuk relasi.
* Pisahkan logika laporan di ReportController.
* Gunakan Chart.js untuk visualisasi.
* Gunakan Laravel Excel untuk ekspor Excel.
* Gunakan DomPDF untuk cetak PDF.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Dashboard Statistik selesai.
* [ ] Card Dashboard selesai.
* [ ] Grafik Penjualan selesai.
* [ ] Grafik Buku Terlaris selesai.
* [ ] Laporan Penjualan selesai.
* [ ] Laporan Pembayaran selesai.
* [ ] Laporan Buku selesai.
* [ ] Laporan Stok selesai.
* [ ] Laporan Customer selesai.
* [ ] Filter Laporan selesai.
* [ ] Export Excel berjalan.
* [ ] Export PDF berjalan.
* [ ] Dashboard Customer selesai.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Dashboard Admin
* Dashboard Customer
* Dashboard Publik
* Statistik Penjualan
* Grafik Penjualan Bulanan
* Grafik Buku Terlaris
* Laporan Penjualan
* Laporan Pembayaran
* Laporan Buku
* Laporan Stok
* Laporan Customer
* Export Excel
* Export PDF
* Filter Laporan

Dengan selesainya modul ini, seluruh fitur utama Sistem Informasi Toko Buku telah lengkap mulai dari pengelolaan master data, katalog publik, autentikasi, keranjang belanja, checkout, pembayaran manual, manajemen pesanan, hingga pelaporan dan statistik.

---

# Tahap Selanjutnya

## 16 - Deployment & Penyelesaian Project

Sebagai modul penutup, mahasiswa akan mempersiapkan aplikasi untuk dipresentasikan dan diunggah ke server. Tahapan ini meliputi:

* Konfigurasi Production (`.env`)
* Optimasi Laravel (`config:cache`, `route:cache`, `view:cache`)
* Upload ke Hosting atau VPS
* Konfigurasi Storage Link
* Backup Database
* Pengujian Black Box
* Penyusunan Manual Book
* Penyusunan Laporan Tugas Akhir
* Persiapan Demo Sidang

Modul ini memastikan aplikasi siap digunakan, dipresentasikan, dan menjadi produk akhir yang layak sebagai proyek Tugas Akhir mahasiswa.
