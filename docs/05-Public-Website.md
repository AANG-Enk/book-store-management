# 05 - Public Website

# 🌐 Membangun Public Website

Public Website merupakan halaman yang dapat diakses oleh semua pengunjung tanpa harus login. Halaman ini berfungsi sebagai media promosi sekaligus katalog buku yang tersedia pada toko buku.

Pada tahap ini kita akan membangun struktur halaman, routing, dan tampilan menggunakan Bootstrap 5. Data yang ditampilkan masih berupa data statis (dummy) dan akan dihubungkan ke database pada modul Master Data.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat halaman publik menggunakan Blade
* Membuat routing website
* Menggunakan layout public
* Membuat tampilan katalog buku
* Membuat halaman detail buku
* Membuat halaman informasi
* Menggunakan komponen Bootstrap untuk website

---

# Struktur Public Website

Website terdiri dari beberapa halaman utama.

```text
Home

↓

Katalog Buku

↓

Detail Buku

↓

Tentang Kami

↓

Kontak

↓

Login / Register
```

---

# Struktur Folder

Seluruh halaman publik disimpan pada folder berikut.

```text
resources
└── views
    └── public
        ├── home.blade.php
        ├── books.blade.php
        ├── detail.blade.php
        ├── about.blade.php
        ├── contact.blade.php
        └── components
            ├── hero.blade.php
            ├── book-card.blade.php
            ├── category-card.blade.php
            └── search-form.blade.php
```

---

# Routing Public Website

Seluruh route publik diletakkan pada file `routes/web.php`.

| URL           | Halaman      |
| ------------- | ------------ |
| /             | Home         |
| /books        | Katalog Buku |
| /books/{slug} | Detail Buku  |
| /about        | Tentang Kami |
| /contact      | Kontak       |

---

# Struktur Controller

Buat controller khusus untuk halaman publik.

```text
app
└── Http
    └── Controllers
        └── Public
            └── HomeController.php
```

Controller ini bertanggung jawab menampilkan seluruh halaman website yang dapat diakses oleh pengunjung.

---

# Halaman Home

Halaman Home merupakan halaman pertama yang dilihat oleh pengunjung.

Komponen yang akan ditampilkan:

* Hero Banner
* Pencarian Buku
* Kategori Buku
* Buku Terbaru
* Buku Terlaris (Dummy)
* Keunggulan Toko
* Call To Action
* Footer

---

# Hero Section

Hero digunakan sebagai identitas website.

Isi Hero:

* Nama Toko Buku
* Deskripsi singkat
* Tombol Lihat Katalog
* Tombol Daftar

---

# Pencarian Buku

Pada halaman Home disediakan form pencarian sederhana.

Komponen:

* Input Keyword
* Tombol Cari

Fitur pencarian akan dihubungkan dengan database pada modul Master Buku.

---

# Kategori Buku

Halaman Home menampilkan beberapa kategori buku.

Contoh kategori:

* Teknologi
* Pemrograman
* Desain
* Bisnis
* Novel
* Pendidikan

Data kategori masih menggunakan data statis.

---

# Buku Terbaru

Menampilkan beberapa kartu buku.

Setiap kartu berisi:

* Cover Buku
* Judul
* Penulis
* Harga
* Tombol Detail

Data masih menggunakan placeholder.

---

# Halaman Katalog Buku

Halaman ini menampilkan seluruh koleksi buku.

Komponen:

* Judul Halaman
* Breadcrumb
* Form Pencarian
* Filter Kategori
* Grid Buku
* Pagination

Pada tahap ini data masih bersifat statis.

---

# Kartu Buku

Setiap buku ditampilkan dalam bentuk Card Bootstrap.

Informasi yang ditampilkan:

* Cover Buku
* Judul
* Penulis
* Harga
* Tombol Detail

Pada modul berikutnya akan ditambahkan tombol **Tambah ke Keranjang** untuk pengguna yang telah login sebagai Customer.

---

# Halaman Detail Buku

Halaman detail berisi informasi lengkap mengenai sebuah buku.

Informasi yang ditampilkan:

* Cover Buku
* Judul
* Penulis
* Penerbit
* Tahun Terbit
* ISBN
* Harga
* Stok (Dummy)
* Deskripsi
* Tombol Tambah ke Keranjang (sementara dinonaktifkan)

---

# Halaman Tentang Kami

Halaman ini menjelaskan profil toko buku.

Isi halaman:

* Sejarah Singkat
* Visi
* Misi
* Alamat
* Jam Operasional

---

# Halaman Kontak

Halaman kontak berisi informasi komunikasi.

Komponen:

* Alamat
* Nomor Telepon
* Email
* Google Maps (Placeholder)
* Form Hubungi Kami (Opsional)

---

# Komponen Bootstrap

Komponen yang digunakan pada Public Website:

* Navbar
* Carousel
* Card
* Grid System
* Button
* Form
* Breadcrumb
* Pagination
* Alert
* Footer

---

# Navigasi Website

Navbar akan menampilkan menu berikut.

```text
Home

Katalog Buku

Tentang Kami

Kontak

Login

Register
```

Apabila pengguna sudah login.

```text
Home

Katalog Buku

Dashboard

Logout
```

---

# Responsive Design

Public Website harus dapat digunakan dengan baik pada:

* Desktop
* Laptop
* Tablet
* Smartphone

Gunakan Grid Bootstrap agar tampilan tetap rapi pada berbagai ukuran layar.

---

# Best Practice

Selama membangun Public Website gunakan aturan berikut:

* Gunakan layout `layouts/public.blade.php`.
* Pisahkan komponen yang sering digunakan ke dalam folder `components`.
* Gunakan Bootstrap Card untuk menampilkan buku.
* Hindari penulisan CSS secara inline.
* Gunakan gambar placeholder dengan ukuran yang konsisten.
* Siapkan struktur Blade agar mudah dihubungkan ke database pada modul berikutnya.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Halaman Home berhasil dibuat.
* [ ] Halaman Katalog Buku berhasil dibuat.
* [ ] Halaman Detail Buku berhasil dibuat.
* [ ] Halaman Tentang Kami berhasil dibuat.
* [ ] Halaman Kontak berhasil dibuat.
* [ ] Navbar Public berfungsi.
* [ ] Hero Section berhasil dibuat.
* [ ] Card Buku berhasil dibuat.
* [ ] Layout Public responsive.
* [ ] Routing seluruh halaman berjalan dengan baik.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Public Website
* Halaman Home
* Katalog Buku
* Detail Buku
* Tentang Kami
* Kontak
* Hero Section
* Grid Buku
* Struktur komponen Blade
* Routing Public Website
* Layout Bootstrap yang responsif

Seluruh halaman sudah siap dihubungkan dengan database pada modul Master Data.

---

# Tahap Selanjutnya

Pada modul **06 - Customer Module** kita akan mulai membangun area khusus pelanggan. Modul ini mencakup Dashboard Customer, halaman Profil, struktur menu pelanggan, serta persiapan halaman Keranjang, Checkout, dan Riwayat Pesanan yang nantinya akan dihubungkan dengan fitur transaksi pada modul-modul berikutnya.
