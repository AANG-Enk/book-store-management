# PRD — BookStore: Sistem Informasi Penjualan Buku Berbasis Web

**Versi:** 1.0  
**Tanggal:** 18 Juni 2026  
**Produk:** BookStore  
**Platform:** Web Application  
**Stack Target:** Laravel 12, PHP 8.3+, MySQL, Bootstrap 5.3, Blade, Bootstrap Icons  
**Sumber Dokumen:** Rangkuman dari dokumen requirement `00-Project-Overview.md` sampai `18-Deployment.md`

---

## 1. Ringkasan Produk

BookStore adalah aplikasi **Sistem Informasi Penjualan Buku Berbasis Web** yang menggabungkan website katalog buku, area customer, dan dashboard admin dalam satu sistem. Aplikasi ini dirancang sebagai studi kasus project mahasiswa tingkat akhir dengan cakupan fitur yang tidak hanya CRUD, tetapi juga memiliki alur bisnis penjualan sederhana mulai dari katalog buku, keranjang belanja, checkout, pembayaran manual, verifikasi admin, manajemen pesanan, laporan, hingga deployment.

Aplikasi dibangun menggunakan Laravel 12 dan Bootstrap 5 agar struktur kode mudah dipahami, tampilannya responsif, serta cocok untuk pembelajaran konsep MVC, authentication, authorization, database relationship, upload file, validasi form, session/cart, report, dan deployment ke hosting.

---

## 2. Latar Belakang

Banyak project pembelajaran Laravel berhenti di fitur CRUD sederhana. BookStore dibuat agar mahasiswa dapat memahami siklus pengembangan aplikasi web yang lebih mendekati kebutuhan bisnis nyata, khususnya pada studi kasus toko buku online.

Sistem ini harus dapat digunakan oleh tiga jenis pengguna utama:

1. **Guest/Pengunjung**, yang dapat melihat informasi website dan katalog buku.
2. **Customer**, yang dapat login, memasukkan buku ke keranjang, checkout, upload bukti pembayaran, dan melihat riwayat pesanan.
3. **Admin**, yang dapat mengelola data master, memproses pesanan, memverifikasi pembayaran, melihat laporan, dan mengelola data sistem.

---

## 3. Tujuan Produk

Tujuan utama produk adalah menyediakan aplikasi toko buku berbasis web yang sederhana, edukatif, dan lengkap secara alur bisnis.

Tujuan detail:

- Menyediakan website katalog buku yang dapat diakses publik.
- Menyediakan authentication untuk admin dan customer.
- Memisahkan hak akses admin dan customer.
- Memungkinkan customer melakukan proses belanja dari katalog sampai pembayaran manual.
- Memungkinkan admin mengelola data buku, kategori, supplier, customer, pesanan, pembayaran, dan laporan.
- Menyediakan fitur laporan untuk kebutuhan monitoring dan dokumentasi tugas akhir.
- Menyediakan struktur project Laravel yang rapi dan mudah dikembangkan.
- Menyediakan alur testing dan deployment sederhana untuk kebutuhan presentasi atau produksi awal.

---

## 4. Sasaran Pembelajaran

Setelah project selesai, mahasiswa diharapkan memahami:

- Struktur project Laravel.
- Authentication menggunakan Laravel Breeze.
- Role dan authorization dasar.
- Routing dan middleware.
- CRUD menggunakan Eloquent ORM.
- Relasi database antar tabel.
- Migration, seeder, dan database design.
- Blade templating dan layouting dengan Bootstrap.
- Validasi form.
- Upload file ke storage.
- Session atau database-based shopping cart.
- Checkout dan pembuatan invoice.
- Pembayaran manual dengan upload bukti transfer.
- Verifikasi pembayaran oleh admin.
- Laporan web, export Excel, dan export PDF.
- Black box testing dan UAT.
- Deployment Laravel ke shared hosting/cPanel.

---

## 5. Ruang Lingkup Produk

### 5.1 In Scope

Fitur yang masuk cakupan utama:

- Public website.
- Login, register, logout, reset password bawaan Breeze.
- Role admin dan customer.
- Dashboard admin.
- Dashboard customer.
- Master kategori buku.
- Master supplier.
- Master buku.
- Katalog buku public.
- Detail buku public.
- Keranjang belanja customer.
- Checkout dan pembuatan pesanan.
- Upload bukti pembayaran.
- Verifikasi pembayaran admin.
- Manajemen pesanan admin.
- Profile dan pengaturan akun.
- Laporan penjualan, pembayaran, stok, dan customer.
- Export laporan Excel.
- Export laporan PDF/print.
- Testing manual: black box dan UAT.
- Deployment ke shared hosting/cPanel.

### 5.2 Out of Scope

Fitur yang tidak menjadi cakupan utama versi ini:

- Payment gateway otomatis seperti Midtrans.
- Ongkir otomatis atau integrasi ekspedisi.
- Multi cabang toko.
- Multi vendor marketplace.
- Chat realtime.
- Notifikasi WhatsApp/email otomatis lanjutan.
- Manajemen retur/refund kompleks.
- Sistem kupon/promo.
- API mobile app.
- Unit test lengkap sebagai kewajiban utama.

Catatan: arsitektur pembayaran manual tetap dapat dikembangkan di masa depan menjadi payment gateway.

---

## 6. Persona Pengguna

### 6.1 Guest / Pengunjung

Pengunjung adalah orang yang belum login. Mereka ingin melihat informasi toko, mencari buku, membaca detail buku, lalu mendaftar jika ingin membeli.

Kebutuhan:

- Melihat home page.
- Melihat katalog buku.
- Mencari buku.
- Melihat detail buku.
- Melihat halaman tentang dan kontak.
- Login/register.

### 6.2 Customer

Customer adalah pengguna yang sudah terdaftar dan memiliki hak akses belanja.

Kebutuhan:

- Login ke sistem.
- Melihat dashboard customer.
- Mengelola profile.
- Menambahkan buku ke keranjang.
- Mengubah jumlah item keranjang.
- Checkout.
- Upload bukti transfer.
- Melihat riwayat dan detail pesanan.
- Melihat status pembayaran dan status pesanan.

### 6.3 Admin

Admin adalah pengelola toko buku dengan hak akses penuh.

Kebutuhan:

- Login ke dashboard admin.
- Mengelola kategori buku.
- Mengelola supplier.
- Mengelola data buku dan stok.
- Melihat customer.
- Mengelola pesanan.
- Memverifikasi pembayaran.
- Melihat dan mencetak laporan.
- Mengelola profile.

---

## 7. Role dan Hak Akses

### 7.1 Admin

Admin dapat mengakses:

- Admin dashboard.
- Master kategori.
- Master supplier.
- Master buku.
- Update stok buku.
- Data customer.
- Manajemen pesanan.
- Manajemen pembayaran.
- Laporan.
- Profile.

Admin tidak menggunakan fitur keranjang/checkout sebagai customer.

### 7.2 Customer

Customer dapat mengakses:

- Customer dashboard.
- Katalog buku.
- Keranjang.
- Checkout.
- Upload bukti pembayaran.
- Riwayat pesanan.
- Detail pesanan miliknya sendiri.
- Profile.

Customer tidak boleh mengakses halaman admin.

### 7.3 Guest

Guest dapat mengakses:

- Home.
- Katalog buku.
- Detail buku.
- Tentang.
- Kontak.
- Login.
- Register.

Guest tidak boleh checkout atau mengakses dashboard.

---

## 8. Arsitektur Area Sistem

Produk dibagi menjadi tiga area utama.

### 8.1 Public Website

Area publik yang dapat diakses tanpa login.

Fitur utama:

- Home.
- Katalog buku.
- Detail buku.
- Tentang kami.
- Kontak.
- Login.
- Register.

### 8.2 Customer Area

Area setelah customer login.

Fitur utama:

- Dashboard customer.
- Profile.
- Keranjang.
- Checkout.
- Upload pembayaran.
- Riwayat pesanan.
- Detail pesanan.

### 8.3 Admin Dashboard

Area khusus admin.

Fitur utama:

- Dashboard admin.
- CRUD kategori.
- CRUD supplier.
- CRUD buku.
- Update stok.
- Manajemen pesanan.
- Verifikasi pembayaran.
- Laporan.
- Profile.

---

## 9. Alur Utama Sistem

### 9.1 Alur Pembelian Customer

```text
Guest membuka website
↓
Guest melihat katalog buku
↓
Guest melihat detail buku
↓
Guest register/login
↓
Customer masuk dashboard
↓
Customer menambahkan buku ke keranjang
↓
Customer checkout
↓
Sistem membuat invoice dan order
↓
Customer transfer manual
↓
Customer upload bukti pembayaran
↓
Admin memverifikasi pembayaran
↓
Order berubah menjadi paid
↓
Admin memproses pesanan
↓
Order selesai
```

### 9.2 Alur Admin Mengelola Data Buku

```text
Admin login
↓
Admin membuka dashboard
↓
Admin mengelola kategori
↓
Admin mengelola supplier
↓
Admin menambahkan/mengedit buku
↓
Admin mengatur stok dan harga
↓
Buku tampil di katalog public
```

### 9.3 Alur Pembayaran Manual

```text
Customer checkout
↓
Order dibuat dengan status waiting_payment
↓
Customer transfer ke rekening toko
↓
Customer upload bukti transfer
↓
Payment dibuat dengan status pending
↓
Admin mengecek bukti pembayaran
↓
Admin verifikasi atau tolak pembayaran
↓
Jika verified, order menjadi paid
↓
Jika rejected, customer dapat upload ulang
```

---

## 10. Modul dan Requirement Fungsional

## 10.1 Setup Project

### Deskripsi

Project dibuat menggunakan Laravel 12 dan dikonfigurasi dengan database MySQL.

### Functional Requirements

- Sistem harus dapat dijalankan di local development.
- Sistem harus menggunakan database MySQL.
- Sistem harus memiliki konfigurasi `.env`.
- Sistem harus dapat menjalankan migration.
- Sistem harus dapat menjalankan Vite untuk asset frontend.
- Sistem harus menggunakan Git sebagai version control.

### Acceptance Criteria

- `php artisan serve` dapat menjalankan aplikasi.
- `npm run dev` atau `npm run build` berjalan tanpa error.
- `php artisan migrate` berhasil membuat tabel database.
- Repository Git memiliki initial commit.

---

## 10.2 Authentication

### Deskripsi

Authentication menggunakan Laravel Breeze Blade untuk menyediakan login, register, logout, dan reset password.

### Functional Requirements

- Guest dapat register sebagai customer.
- User dapat login menggunakan email dan password.
- User dapat logout.
- Halaman dashboard hanya dapat diakses oleh user login.
- User yang belum login diarahkan ke login ketika membuka halaman protected.

### Acceptance Criteria

- Register berhasil membuat user baru.
- Login berhasil membuat session.
- Logout menghapus session.
- Email/password salah menampilkan error validasi.
- Route protected tidak dapat diakses guest.

---

## 10.3 Role & Permission

### Deskripsi

Sistem memiliki dua role utama: admin dan customer.

### Functional Requirements

- User memiliki field role.
- Admin diarahkan ke dashboard admin.
- Customer diarahkan ke dashboard customer.
- Admin middleware membatasi akses admin.
- Customer middleware membatasi akses customer.
- Customer tidak dapat membuka URL admin.
- Admin tidak diarahkan ke fitur customer seperti keranjang.

### Acceptance Criteria

- User role `admin` dapat membuka `/admin/dashboard`.
- User role `customer` dapat membuka `/customer/dashboard`.
- Customer membuka `/admin/dashboard` mendapat 403.
- Admin membuka route customer mendapat 403 atau redirect sesuai kebijakan sistem.

---

## 10.4 Layout Bootstrap

### Deskripsi

Sistem menggunakan Bootstrap 5 untuk membangun layout public, customer, admin, dan guest/auth.

### Functional Requirements

- Public layout memiliki navbar dan footer.
- Admin layout memiliki sidebar, topbar, content area, dan flash message.
- Customer layout memiliki navbar customer, content area, dan footer.
- Guest layout digunakan untuk login/register.
- Layout harus responsive di desktop, tablet, dan mobile.
- UI harus mudah dibaca dan konsisten.

### Acceptance Criteria

- Navbar public tampil di halaman public.
- Sidebar admin tampil di halaman admin.
- Navbar customer tampil di halaman customer.
- Flash success/error tampil dengan benar.
- Tampilan tidak rusak pada layar mobile.

---

## 10.5 Public Website

### Deskripsi

Public website menampilkan informasi toko dan katalog buku kepada pengunjung.

### Functional Requirements

- Guest dapat membuka home page.
- Guest dapat membuka katalog buku.
- Guest dapat melihat detail buku.
- Guest dapat melihat halaman tentang.
- Guest dapat membuka halaman kontak.
- Guest dapat mengirim pesan kontak.
- Guest dapat login/register.
- Katalog hanya menampilkan buku aktif dan kategori aktif.
- Katalog mendukung search dan filter kategori.

### Acceptance Criteria

- `/` menampilkan landing/home page.
- `/katalog` menampilkan daftar buku aktif.
- `/katalog/{slug}` menampilkan detail buku aktif.
- `/tentang` menampilkan informasi toko.
- `/kontak` menampilkan form kontak.
- Submit kontak valid menyimpan data pesan.
- Search katalog menampilkan hasil sesuai kata kunci.

---

## 10.6 Customer Module

### Deskripsi

Customer area memungkinkan customer mengelola aktivitas belanja.

### Functional Requirements

- Customer memiliki dashboard.
- Customer dapat melihat ringkasan keranjang dan pesanan.
- Customer dapat mengakses katalog.
- Customer dapat mengakses keranjang.
- Customer dapat mengakses riwayat pesanan.
- Customer hanya dapat melihat pesanan miliknya sendiri.
- Customer dapat mengelola profile.

### Acceptance Criteria

- `/customer/dashboard` dapat diakses customer login.
- Dashboard menampilkan ringkasan item keranjang dan total pesanan.
- Customer tidak dapat membuka detail pesanan customer lain.

---

## 10.7 Admin Dashboard

### Deskripsi

Admin dashboard menampilkan ringkasan sistem dan shortcut modul pengelolaan.

### Functional Requirements

- Dashboard menampilkan total buku.
- Dashboard menampilkan total kategori.
- Dashboard menampilkan total customer.
- Dashboard menampilkan total pesanan.
- Dashboard menampilkan pembayaran pending.
- Dashboard menampilkan stok menipis/habis.
- Dashboard menampilkan pesan kontak belum dibaca.
- Dashboard menyediakan shortcut ke modul penting.

### Acceptance Criteria

- `/admin/dashboard` dapat diakses admin login.
- Statistik dashboard sesuai data database.
- Shortcut mengarah ke route yang benar.

---

## 10.8 Master Kategori Buku

### Deskripsi

Admin dapat mengelola kategori buku.

### Functional Requirements

- Admin dapat melihat daftar kategori.
- Admin dapat menambah kategori.
- Admin dapat mengedit kategori.
- Admin dapat menghapus kategori jika belum digunakan buku.
- Kategori memiliki nama, slug, deskripsi, dan status aktif.
- Slug kategori unik.
- Daftar kategori mendukung search dan filter status.

### Acceptance Criteria

- Kategori baru berhasil disimpan.
- Nama kategori wajib diisi.
- Slug otomatis terbentuk dan unik.
- Kategori yang digunakan buku tidak dapat dihapus.
- Kategori nonaktif tidak tampil di katalog public.

---

## 10.9 Master Buku

### Deskripsi

Admin dapat mengelola data buku yang dijual.

### Functional Requirements

- Admin dapat melihat daftar buku.
- Admin dapat menambah buku.
- Admin dapat mengedit buku.
- Admin dapat menghapus buku jika belum masuk order/keranjang.
- Buku memiliki kategori.
- Buku dapat memiliki supplier.
- Buku memiliki judul, slug, penulis, penerbit, tahun terbit, ISBN, deskripsi, stok, harga, cover image, dan status aktif.
- Slug buku unik.
- ISBN unik jika diisi.
- Cover image dapat diupload.
- Buku dapat dicari berdasarkan judul, penulis, penerbit, atau ISBN.
- Buku dapat difilter berdasarkan kategori, supplier, dan status.

### Acceptance Criteria

- Buku valid berhasil disimpan.
- Buku tanpa judul tidak dapat disimpan.
- Harga dan stok tidak boleh negatif.
- Cover hanya menerima gambar valid.
- Buku nonaktif tidak tampil di katalog public.
- Buku yang sudah masuk order tidak dapat dihapus.

---

## 10.10 Master Supplier

### Deskripsi

Admin dapat mengelola supplier sebagai sumber stok buku.

### Functional Requirements

- Admin dapat melihat daftar supplier.
- Admin dapat menambah supplier.
- Admin dapat mengedit supplier.
- Admin dapat menghapus supplier jika belum digunakan buku.
- Supplier memiliki nama, telepon, email, alamat, catatan, dan status aktif.
- Daftar supplier mendukung search dan filter status.

### Acceptance Criteria

- Supplier valid berhasil disimpan.
- Nama supplier wajib diisi.
- Email supplier harus valid jika diisi.
- Supplier yang masih digunakan buku tidak dapat dihapus.

---

## 10.11 Keranjang Belanja

### Deskripsi

Customer dapat menyimpan buku yang ingin dibeli sebelum checkout.

### Functional Requirements

- Customer dapat menambahkan buku ke keranjang.
- Customer dapat melihat isi keranjang.
- Customer dapat mengubah quantity item.
- Customer dapat menghapus item.
- Customer dapat mengosongkan keranjang.
- Quantity tidak boleh kurang dari 1.
- Quantity tidak boleh melebihi stok buku.
- Buku stok habis tidak dapat ditambahkan.
- Keranjang hanya milik customer login.

### Acceptance Criteria

- Tambah buku ke keranjang berhasil.
- Item yang sama ditambahkan lagi akan menambah quantity.
- Update quantity mengubah subtotal.
- Hapus item menghapus data keranjang.
- Checkout tidak dapat dilakukan jika keranjang kosong.

---

## 10.12 Checkout

### Deskripsi

Checkout mengubah isi keranjang menjadi pesanan resmi.

### Functional Requirements

- Customer dapat membuka halaman checkout jika keranjang tidak kosong.
- Customer mengisi nama, email, no telepon, alamat pengiriman, dan catatan.
- Sistem membuat nomor invoice otomatis.
- Sistem membuat data order.
- Sistem membuat data order item.
- Sistem mengurangi stok buku setelah checkout berhasil.
- Sistem mengosongkan keranjang setelah checkout berhasil.
- Status order awal setelah checkout adalah menunggu pembayaran.

### Acceptance Criteria

- Checkout berhasil membuat invoice.
- Total order sama dengan subtotal seluruh item.
- Stok buku berkurang sesuai quantity.
- Keranjang customer kosong setelah checkout.
- Checkout gagal jika stok tidak mencukupi.

---

## 10.13 Pembayaran Manual

### Deskripsi

Customer melakukan transfer bank manual lalu upload bukti pembayaran. Admin melakukan verifikasi.

### Functional Requirements

- Customer dapat upload bukti pembayaran untuk order miliknya.
- Data pembayaran menyimpan order, metode pembayaran, bank/metode, nama pengirim, nominal transfer, bukti gambar, status, catatan admin, dan tanggal verifikasi.
- Format bukti pembayaran harus gambar.
- Admin dapat melihat daftar pembayaran.
- Admin dapat melihat detail pembayaran dan bukti transfer.
- Admin dapat memverifikasi pembayaran.
- Admin dapat menolak pembayaran dengan catatan.
- Jika pembayaran verified, status order menjadi paid.
- Jika pembayaran rejected, customer dapat upload ulang.

### Acceptance Criteria

- Upload bukti pembayaran valid berhasil.
- Payment status awal adalah pending.
- Admin verify mengubah payment menjadi verified dan order menjadi paid.
- Admin reject mengubah payment menjadi rejected dan menyimpan catatan.
- Customer tidak dapat upload bukti untuk order orang lain.

---

## 10.14 Manajemen Pesanan

### Deskripsi

Admin mengelola status pesanan customer setelah checkout dan pembayaran.

### Functional Requirements

- Admin dapat melihat daftar semua pesanan.
- Admin dapat search invoice, nama customer, email, atau no telepon.
- Admin dapat filter status pesanan.
- Admin dapat melihat detail pesanan.
- Detail pesanan menampilkan data customer, alamat, item order, total, status order, dan pembayaran.
- Admin dapat update status order.
- Status order meliputi waiting_payment, paid, processing, completed, cancelled.
- Admin sebaiknya hanya mengubah order ke paid jika pembayaran sudah verified.

### Acceptance Criteria

- Daftar order tampil sesuai database.
- Detail order menampilkan item dan total benar.
- Update status berhasil menyimpan status baru.
- Customer melihat status terbaru di detail pesanan.

---

## 10.15 Laporan

### Deskripsi

Admin dapat melihat laporan sistem untuk penjualan, pembayaran, stok, dan customer.

### Functional Requirements

- Admin dapat membuka halaman pusat laporan.
- Admin dapat melihat laporan penjualan.
- Admin dapat filter laporan penjualan berdasarkan tanggal dan status order.
- Admin dapat melihat laporan pembayaran.
- Admin dapat filter laporan pembayaran berdasarkan tanggal dan status pembayaran.
- Admin dapat melihat laporan stok buku.
- Admin dapat filter stok habis, menipis, dan aman.
- Admin dapat melihat laporan customer.
- Admin dapat search customer.
- Admin dapat export laporan ke Excel.
- Admin dapat export laporan ke PDF.
- Admin dapat print laporan.

### Acceptance Criteria

- Total laporan berubah sesuai filter.
- Export Excel menghasilkan file `.xlsx` valid.
- Export PDF menghasilkan file `.pdf` valid.
- Print browser menampilkan layout laporan yang rapi.

---

## 10.16 Profile & Pengaturan Akun

### Deskripsi

Admin dan customer dapat mengelola informasi akun.

### Functional Requirements

- User dapat melihat profile.
- User dapat mengubah nama dan email.
- User dapat mengganti password.
- User dapat menghapus akun jika fitur bawaan tersedia.
- Jika dikembangkan, user dapat mengisi phone, address, dan avatar.
- Password baru harus tervalidasi.

### Acceptance Criteria

- Update profile berhasil.
- Email harus unik.
- Password dapat diubah dengan validasi yang benar.
- Error validasi tampil jika input tidak valid.

---

## 10.17 Testing

### Deskripsi

Testing dilakukan untuk memastikan seluruh fitur berjalan sesuai kebutuhan.

### Functional Requirements

- Testing dilakukan dengan black box testing.
- UAT dilakukan dengan responden pengguna akhir atau simulasi.
- Modul yang diuji meliputi login, register, dashboard, CRUD, keranjang, checkout, pembayaran, pesanan, laporan, dan profile.
- Pengujian mencakup input valid dan invalid.
- Hasil testing didokumentasikan dalam tabel.

### Acceptance Criteria

- Semua skenario utama memiliki status pengujian.
- Bug kritis diperbaiki sebelum deployment.
- Hasil UAT terdokumentasi.

---

## 10.18 Deployment

### Deskripsi

Aplikasi disiapkan untuk deployment ke shared hosting/cPanel.

### Functional Requirements

- Project dapat dipaketkan untuk upload ke hosting.
- Database dapat diexport dari local dan diimport ke hosting.
- `.env` production dikonfigurasi.
- `public` Laravel diarahkan ke `public_html`.
- `index.php` disesuaikan path-nya.
- Storage link atau akses file upload disiapkan.
- Cache production dikonfigurasi.

### Acceptance Criteria

- Aplikasi dapat diakses dari domain hosting.
- Database production terkoneksi.
- Login dan fitur utama berjalan di hosting.
- Upload file dapat diakses dari browser.
- Tidak ada debug/error development yang tampil di production.

---

## 11. Data Model Utama

### 11.1 Users

Menyimpan data pengguna.

Field utama:

- id
- name
- email
- password
- role
- email_verified_at
- remember_token
- timestamps

Opsional lanjutan:

- phone
- address
- avatar

Relasi:

- User memiliki banyak cart items.
- User memiliki banyak orders.

### 11.2 Categories

Menyimpan kategori buku.

Field utama:

- id
- name
- slug
- description
- is_active
- timestamps

Relasi:

- Category memiliki banyak books.

### 11.3 Suppliers

Menyimpan data supplier.

Field utama:

- id
- name
- phone
- email
- address
- notes
- is_active
- timestamps

Relasi:

- Supplier memiliki banyak books.

### 11.4 Books

Menyimpan data buku.

Field utama:

- id
- category_id
- supplier_id
- title
- slug
- author
- publisher
- publication_year
- isbn
- description
- stock
- price
- cover_image
- is_active
- timestamps

Relasi:

- Book belongs to category.
- Book belongs to supplier.
- Book memiliki banyak cart items.
- Book memiliki banyak order items.

### 11.5 Cart Items

Menyimpan item keranjang customer.

Field utama:

- id
- user_id
- book_id
- quantity
- timestamps

Relasi:

- CartItem belongs to user.
- CartItem belongs to book.

### 11.6 Orders

Menyimpan data pesanan.

Field utama:

- id
- user_id
- invoice_number
- customer_name
- customer_email
- customer_phone
- shipping_address
- total_price
- status
- notes
- timestamps

Relasi:

- Order belongs to user.
- Order memiliki banyak order items.
- Order memiliki satu payment.

### 11.7 Order Items

Menyimpan detail item dalam pesanan.

Field utama:

- id
- order_id
- book_id
- book_title
- book_price
- quantity
- subtotal
- timestamps

Relasi:

- OrderItem belongs to order.
- OrderItem belongs to book.

### 11.8 Payments

Menyimpan bukti pembayaran manual.

Field utama:

- id
- order_id
- payment_method
- bank_name
- sender_name
- transfer_amount
- proof_image
- status
- admin_note
- verified_at
- timestamps

Relasi:

- Payment belongs to order.

### 11.9 Contact Messages

Menyimpan pesan dari halaman kontak.

Field utama:

- id
- name
- email
- phone
- subject
- message
- is_read
- read_at
- timestamps

---

## 12. Status dan State Management

### 12.1 Status Order

- `waiting_payment` — pesanan menunggu pembayaran.
- `paid` — pembayaran sudah diverifikasi.
- `processing` — pesanan sedang diproses.
- `completed` — pesanan selesai.
- `cancelled` — pesanan dibatalkan.

### 12.2 Status Payment

- `pending` — bukti pembayaran menunggu verifikasi.
- `verified` — pembayaran diterima.
- `rejected` — pembayaran ditolak dan customer dapat upload ulang.

### 12.3 Status Stok

- Habis: stock = 0.
- Menipis: stock > 0 dan stock <= 5.
- Aman: stock > 5.

---

## 13. UI/UX Requirement

### 13.1 General UI

- Menggunakan Bootstrap 5.
- Desain harus sederhana, mudah dipahami, dan responsif.
- Layout harus konsisten antara public, customer, dan admin.
- Tabel harus dibungkus dengan `.table-responsive`.
- Form harus menampilkan error validasi jelas.
- Tombol utama harus mudah ditemukan.
- Empty state harus tersedia ketika data kosong.

### 13.2 Public UI

- Home menampilkan pengantar toko dan CTA ke katalog.
- Katalog menampilkan card buku dengan cover, judul, kategori, harga, stok, dan tombol detail.
- Detail buku menampilkan informasi lengkap dan CTA belanja.
- Tentang menampilkan informasi toko/sistem.
- Kontak menyediakan form pesan.

### 13.3 Customer UI

- Dashboard customer menampilkan ringkasan aktivitas belanja.
- Keranjang menampilkan daftar item dan ringkasan total.
- Checkout menampilkan form data customer dan ringkasan order.
- Detail pesanan menampilkan status order dan pembayaran.
- Upload pembayaran harus sederhana dan jelas.

### 13.4 Admin UI

- Dashboard admin menampilkan statistik sistem dan shortcut.
- Sidebar admin harus mudah dipahami.
- Form admin harus konsisten.
- Tabel admin harus mendukung search, filter, pagination, dan aksi.
- Laporan harus mudah dibaca dan dicetak.

---

## 14. Accessibility Requirement

Aplikasi harus memperhatikan aksesibilitas dasar:

- Teks utama menggunakan kontras warna yang cukup.
- Tombol dan link memiliki label yang jelas.
- Form input memiliki label.
- Error validasi mudah dibaca.
- Navigasi keyboard tetap dapat digunakan.
- Focus state harus terlihat.
- Tampilan responsive untuk mobile.
- Informasi penting tidak hanya dibedakan dengan warna.

---

## 15. Non-Functional Requirements

### 15.1 Performance

- Halaman daftar data menggunakan pagination.
- Query daftar data menggunakan eager loading untuk relasi penting.
- Asset frontend dibuild menggunakan Vite.
- File upload dibatasi ukuran.

### 15.2 Security

- Password harus di-hash.
- Route admin dilindungi middleware admin.
- Route customer dilindungi middleware customer.
- CSRF aktif pada semua form.
- File upload divalidasi tipe dan ukuran.
- Customer hanya dapat melihat data miliknya sendiri.
- Input form divalidasi server-side.

### 15.3 Maintainability

- Gunakan controller terpisah berdasarkan area admin/customer/public.
- Gunakan model relationship Eloquent.
- Gunakan layout dan partial Blade reusable.
- Gunakan migration dan seeder.
- Gunakan naming route konsisten.

### 15.4 Compatibility

- Aplikasi berjalan di PHP 8.3+.
- Aplikasi menggunakan MySQL.
- Aplikasi dapat berjalan di localhost dan shared hosting/cPanel.
- UI mendukung browser modern.

---

## 16. Dependencies

Dependency utama:

- Laravel 12.
- Laravel Breeze.
- Bootstrap 5.3.
- Bootstrap Icons.
- MySQL.
- Vite.
- DomPDF untuk export PDF.
- Laravel Excel untuk export Excel.

Dependency opsional dari dokumen:

- SweetAlert2 untuk alert dialog.
- Chart.js untuk dashboard chart.

---

## 17. Milestone Implementasi

### Milestone 1 — Foundation

- Setup Laravel.
- Database config.
- Breeze authentication.
- Role admin/customer.
- Layout Bootstrap.

### Milestone 2 — Public dan Master Data

- Public website.
- Katalog dan detail buku.
- CRUD kategori.
- CRUD supplier.
- CRUD buku.

### Milestone 3 — Customer Transaction Flow

- Customer dashboard.
- Keranjang.
- Checkout.
- Order dan order item.
- Upload bukti pembayaran.

### Milestone 4 — Admin Transaction Flow

- Admin dashboard.
- Manajemen pesanan.
- Manajemen pembayaran.
- Verifikasi pembayaran.
- Update status order.

### Milestone 5 — Reporting dan Profile

- Laporan web.
- Export Excel.
- Export PDF/print.
- Profile.
- Pesan kontak.

### Milestone 6 — Testing dan Deployment

- Black box testing.
- UAT.
- Bug fixing.
- Deployment ke hosting.

---

## 18. Acceptance Criteria Global

Project dianggap selesai jika:

- Guest dapat membuka public website dan katalog.
- Customer dapat register, login, belanja, checkout, upload bukti pembayaran, dan melihat riwayat pesanan.
- Admin dapat login, mengelola master data, memverifikasi pembayaran, mengelola pesanan, dan melihat laporan.
- Role access berjalan dengan benar.
- CRUD utama berjalan dengan validasi.
- Stok berkurang ketika checkout berhasil.
- Customer tidak dapat melihat data milik customer lain.
- Admin dapat export laporan Excel dan PDF.
- Form kontak public menyimpan pesan ke admin.
- UI responsive di desktop dan mobile.
- Black box testing utama lulus.
- Aplikasi dapat dijalankan di local dan siap deployment.

---

## 19. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
| --- | --- | --- |
| Role salah konfigurasi | Customer dapat akses admin | Gunakan middleware dan testing akses |
| Stok tidak sinkron | Order melebihi stok | Validasi stok saat cart dan checkout |
| Upload file tidak valid | File berbahaya/terlalu besar | Validasi mime dan size |
| Invoice duplikat | Data order bermasalah | Generate invoice dengan tanggal + sequence |
| Query laporan lambat | Halaman admin berat | Pagination dan eager loading |
| Export PDF layout rusak | Laporan sulit dibaca | Gunakan CSS PDF sederhana |
| Deployment cPanel salah path | Aplikasi tidak bisa dibuka | Dokumentasikan struktur public_html dan index.php |

---

## 20. Testing Plan Ringkas

### 20.1 Black Box Testing

Modul yang harus diuji:

- Register.
- Login.
- Logout.
- Role redirect.
- CRUD kategori.
- CRUD supplier.
- CRUD buku.
- Katalog dan detail buku.
- Keranjang.
- Checkout.
- Upload pembayaran.
- Verifikasi pembayaran.
- Manajemen pesanan.
- Laporan dan export.
- Profile.
- Kontak.

### 20.2 UAT

UAT dapat dilakukan dengan skala Likert 1–5 untuk aspek:

- Tampilan aplikasi menarik.
- Menu mudah dipahami.
- Fitur berjalan dengan baik.
- Proses checkout mudah.
- Laporan mudah digunakan.
- Sistem layak digunakan sebagai aplikasi toko buku sederhana.

---

## 21. Deployment Plan Ringkas

Langkah deployment:

1. Pastikan semua fitur selesai dan testing lulus.
2. Backup project dan database.
3. Export database dari local.
4. Upload project ke hosting/cPanel.
5. Pindahkan isi folder `public` ke `public_html` jika menggunakan struktur cPanel manual.
6. Sesuaikan path `index.php`.
7. Buat database dan user di hosting.
8. Import database.
9. Konfigurasi `.env` production.
10. Jalankan composer install jika hosting mendukung.
11. Set permission storage/cache.
12. Pastikan upload file dapat diakses.
13. Uji login, katalog, checkout, upload pembayaran, dan laporan.

---

## 22. Catatan Pengembangan Lanjutan

Fitur yang dapat dikembangkan setelah versi utama selesai:

- Payment gateway Midtrans.
- Notifikasi email setelah order/payment.
- Notifikasi WhatsApp.
- Dashboard chart menggunakan Chart.js.
- Manajemen customer lebih lengkap.
- Diskon atau voucher.
- Ongkir dan ekspedisi.
- Invoice PDF per pesanan.
- Audit log admin.
- Soft delete pada master data.
- API untuk mobile app.

---

## 23. Penutup

PRD ini merangkum kebutuhan produk BookStore sebagai aplikasi sistem informasi penjualan buku berbasis web. Dokumen ini dapat digunakan sebagai acuan pengembangan, presentasi project, pengujian, dokumentasi tugas akhir, dan validasi fitur sebelum deployment.

