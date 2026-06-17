# 04 - Layout Bootstrap

# 🎨 Membangun Layout Aplikasi dengan Bootstrap 5

Pada tahap ini kita akan mengganti tampilan bawaan Laravel Breeze dengan layout baru menggunakan **Bootstrap 5**.

Seluruh halaman pada aplikasi akan menggunakan layout yang sama sehingga tampilan lebih konsisten dan mudah dikembangkan.

Setelah modul ini selesai, project akan memiliki tiga jenis layout utama:

* Public Website
* Customer Area
* Admin Dashboard

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Mengintegrasikan Bootstrap 5 ke Laravel
* Menggunakan Bootstrap Icons
* Membuat Master Layout Blade
* Menggunakan Partial View
* Menggunakan Blade Template Inheritance
* Membuat Sidebar
* Membuat Navbar
* Membuat Footer
* Membuat Breadcrumb
* Menata struktur folder View

---

# Konsep Layout

Agar tidak terjadi pengulangan kode, seluruh halaman akan menggunakan sistem **Master Layout**.

Struktur sederhananya sebagai berikut.

```text
Master Layout

│

├── Navbar

├── Sidebar

├── Content

└── Footer
```

Setiap halaman nantinya hanya mengisi bagian **Content**.

---

# Struktur Layout

Folder layout akan dipisahkan berdasarkan area aplikasi.

```text
resources

views

├── layouts
│   ├── public.blade.php
│   ├── customer.blade.php
│   └── admin.blade.php
│
├── partials
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── sidebar-admin.blade.php
│   ├── sidebar-customer.blade.php
│   ├── breadcrumb.blade.php
│   └── alert.blade.php
│
├── public
├── customer
└── admin
```

---

# Instalasi Bootstrap

Install Bootstrap menggunakan NPM.

```bash
npm install bootstrap
```

Install Bootstrap Icons.

```bash
npm install bootstrap-icons
```

---

# Import Bootstrap

Tambahkan Bootstrap pada file frontend Laravel.

```text
resources

css
└── app.css

resources

js
└── app.js
```

Bootstrap akan di-compile menggunakan Vite sehingga seluruh halaman menggunakan asset yang sama.

---

# Layout Public Website

Layout Public digunakan untuk pengunjung yang belum login.

Komponen yang digunakan:

* Navbar
* Hero Section
* Content
* Footer

Struktur halaman.

```text
Navbar

↓

Hero Banner

↓

Content

↓

Footer
```

---

# Layout Customer

Customer memiliki dashboard sendiri.

Komponen:

* Top Navbar
* Sidebar
* Breadcrumb
* Content
* Footer

```text
Navbar

↓

Sidebar

↓

Breadcrumb

↓

Content

↓

Footer
```

---

# Layout Admin

Admin menggunakan layout yang hampir sama dengan Customer.

Komponen:

* Navbar
* Sidebar
* Breadcrumb
* Dashboard Card
* Content
* Footer

```text
Navbar

↓

Sidebar

↓

Breadcrumb

↓

Dashboard

↓

Footer
```

---

# Struktur Sidebar Admin

Sidebar Administrator akan berisi menu berikut.

```text
Dashboard

Master Data

├── Kategori

├── Buku

├── Supplier

Transaksi

├── Pesanan

├── Pembayaran

Laporan

Profile

Logout
```

---

# Struktur Sidebar Customer

Sidebar Customer.

```text
Dashboard

Katalog Buku

Keranjang

Checkout

Riwayat Pesanan

Profile

Logout
```

---

# Struktur Navbar Public

Menu navigasi website.

```text
Home

Katalog Buku

Tentang

Kontak

Login

Register
```

Setelah login.

```text
Home

Katalog Buku

Dashboard

Logout
```

---

# Warna Aplikasi

Agar tampilan konsisten, gunakan warna Bootstrap.

| Fungsi    | Class Bootstrap |
| --------- | --------------- |
| Primary   | primary         |
| Success   | success         |
| Danger    | danger          |
| Warning   | warning         |
| Info      | info            |
| Secondary | secondary       |

Tidak disarankan menggunakan warna custom pada project ini.

---

# Komponen Bootstrap yang Digunakan

Selama project berlangsung komponen berikut akan sering digunakan.

* Navbar
* Sidebar
* Card
* Table
* Form
* Button
* Badge
* Alert
* Modal
* Pagination
* Dropdown
* Toast
* Breadcrumb
* Accordion
* Carousel

---

# Blade Template

Semua halaman menggunakan Blade Inheritance.

Contoh struktur.

```text
Layout

↓

Yield Content

↓

Halaman
```

Dengan demikian tidak perlu mengulangi kode Navbar maupun Sidebar.

---

# Struktur Folder Public

```text
resources

views

public

├── home.blade.php

├── books.blade.php

├── detail.blade.php

├── about.blade.php

└── contact.blade.php
```

---

# Struktur Folder Customer

```text
resources

views

customer

├── dashboard

├── cart

├── checkout

├── orders

└── profile
```

---

# Struktur Folder Admin

```text
resources

views

admin

├── dashboard

├── books

├── categories

├── suppliers

├── orders

├── reports

└── profile
```

---

# Struktur Asset

Agar mudah dikelola, asset dipisahkan menjadi beberapa folder.

```text
resources

css

js

images
```

Apabila terdapat gambar upload dari pengguna, file akan disimpan pada folder **storage**, bukan di dalam folder **resources**.

---

# Responsive Design

Seluruh halaman wajib dapat digunakan pada:

* Desktop
* Laptop
* Tablet
* Smartphone

Gunakan Grid System Bootstrap untuk mengatur tata letak halaman.

---

# Best Practice

Selama pengembangan gunakan aturan berikut.

* Gunakan satu layout untuk setiap area aplikasi.
* Jangan mengulangi kode Navbar.
* Jangan mengulangi kode Sidebar.
* Gunakan Partial View.
* Gunakan Bootstrap Utility Class.
* Hindari inline CSS.
* Hindari inline JavaScript.
* Gunakan Bootstrap Icons secara konsisten.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Bootstrap berhasil diinstall.
* [ ] Bootstrap Icons berhasil diinstall.
* [ ] Layout Public berhasil dibuat.
* [ ] Layout Customer berhasil dibuat.
* [ ] Layout Admin berhasil dibuat.
* [ ] Navbar berhasil dibuat.
* [ ] Sidebar Admin berhasil dibuat.
* [ ] Sidebar Customer berhasil dibuat.
* [ ] Footer berhasil dibuat.
* [ ] Breadcrumb berhasil dibuat.
* [ ] Seluruh layout responsive.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Bootstrap 5
* Bootstrap Icons
* Master Layout
* Layout Public
* Layout Customer
* Layout Admin
* Navbar
* Sidebar
* Footer
* Breadcrumb
* Struktur View yang rapi
* Tampilan yang konsisten pada seluruh halaman

Dengan fondasi ini, setiap modul berikutnya hanya akan fokus pada implementasi fitur tanpa perlu membuat ulang struktur tampilan.

---

# Tahap Selanjutnya

Pada modul **05 - Public Website** kita akan mulai membangun halaman yang dapat diakses oleh semua pengunjung, meliputi **Home**, **Katalog Buku**, **Detail Buku**, **Tentang Kami**, dan **Kontak**. Halaman-halaman tersebut akan menggunakan layout Bootstrap yang telah dibuat pada modul ini dan menjadi wajah utama aplikasi BookStore.
