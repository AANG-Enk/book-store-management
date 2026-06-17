# 03 - Role & Permission

# 👥 Role & Permission

Pada tahap ini kita akan membedakan hak akses antara **Administrator** dan **Customer** menggunakan sistem role sederhana.

Project ini **tidak menggunakan package tambahan** seperti Spatie Laravel Permission. Sebagai gantinya, kita akan memanfaatkan kolom `role` pada tabel `users` dan middleware custom yang dibuat sendiri.

Pendekatan ini lebih sederhana, mudah dipahami, dan sesuai untuk kebutuhan project tingkat mahasiswa.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Memahami konsep Role & Permission
* Menambahkan kolom role pada tabel users
* Membuat Middleware Role
* Melindungi route berdasarkan role
* Redirect pengguna sesuai role
* Membatasi akses halaman Admin

---

# Konsep Role

Dalam aplikasi BookStore terdapat dua jenis pengguna.

## Administrator

Administrator memiliki hak akses penuh terhadap sistem.

Hak akses:

* Dashboard Admin
* Kelola Buku
* Kelola Kategori
* Kelola Supplier
* Kelola Customer
* Kelola Pesanan
* Verifikasi Pembayaran
* Laporan
* Profile

---

## Customer

Customer merupakan pengguna yang melakukan pembelian buku.

Hak akses:

* Dashboard Customer
* Profile
* Katalog Buku
* Keranjang
* Checkout
* Riwayat Pesanan
* Upload Bukti Transfer

---

# Flow Login

```text
Guest

↓

Login

↓

Cek Role

↓

Admin ?
│
├── Ya → Admin Dashboard
│
└── Tidak → Customer Dashboard
```

---

# Menambahkan Kolom Role

Tambahkan migration baru.

```bash
php artisan make:migration add_role_to_users_table
```

Kolom yang akan ditambahkan.

```text
role

enum

admin
customer
```

Nilai default:

```text
customer
```

Dengan demikian setiap pengguna yang melakukan registrasi akan otomatis menjadi Customer.

---

# Struktur Database

Tabel users setelah ditambahkan role.

```text
users

id
name
email
role
password
remember_token
created_at
updated_at
```

---

# Role yang Digunakan

| Role     | Keterangan           |
| -------- | -------------------- |
| admin    | Administrator Sistem |
| customer | Pembeli Buku         |

---

# Membuat Middleware

Buat middleware baru.

```bash
php artisan make:middleware RoleMiddleware
```

Middleware ini bertugas:

* Mengecek apakah user sudah login.
* Mengecek role pengguna.
* Mengizinkan akses jika role sesuai.
* Mengembalikan halaman 403 jika role tidak sesuai.

---

# Registrasi Middleware

Setelah middleware dibuat, daftarkan middleware pada Laravel agar dapat digunakan pada route.

Nama middleware yang akan digunakan:

```text
role
```

---

# Penggunaan Middleware

Contoh penggunaan pada route.

```php
Route::middleware(['auth', 'role:admin'])->group(function () {

});
```

Untuk Customer.

```php
Route::middleware(['auth', 'role:customer'])->group(function () {

});
```

---

# Struktur Route

Project akan dipisahkan menjadi beberapa file route agar lebih rapi.

```text
routes

web.php

auth.php

admin.php

customer.php
```

Keterangan:

| File         | Fungsi             |
| ------------ | ------------------ |
| web.php      | Public Website     |
| auth.php     | Authentication     |
| admin.php    | Dashboard Admin    |
| customer.php | Dashboard Customer |

---

# Redirect Setelah Login

Setelah berhasil login, sistem akan melakukan pengecekan role.

Jika:

```text
admin
```

Maka diarahkan ke:

```text
/admin/dashboard
```

Jika:

```text
customer
```

Maka diarahkan ke:

```text
/customer/dashboard
```

---

# Struktur Folder View

Mulai tahap ini struktur Blade akan dipisahkan.

```text
resources

views

├── admin
│   └── dashboard
│
├── customer
│   └── dashboard
│
├── public
│
├── auth
│
├── layouts
│
└── partials
```

---

# Struktur Controller

Controller juga dipisahkan berdasarkan area aplikasi.

```text
app

Http

Controllers

├── Admin
│
├── Customer
│
├── Public
│
└── Auth
```

Dengan struktur ini kode akan lebih mudah dikelola ketika jumlah fitur semakin banyak.

---

# Seeder Administrator

Buat seeder untuk Administrator.

Administrator pertama.

```text
Nama

Administrator
```

Email.

```text
admin@bookstore.test
```

Password.

```text
password
```

Role.

```text
admin
```

Seeder ini memudahkan proses login tanpa harus membuat akun secara manual.

---

# Pengujian

Lakukan beberapa pengujian berikut.

## Login Admin

Pastikan berhasil masuk ke Dashboard Admin.

---

## Login Customer

Pastikan berhasil masuk ke Dashboard Customer.

---

## Guest Mengakses Admin

Pastikan diarahkan ke halaman Login.

---

## Customer Mengakses Admin

Pastikan muncul halaman 403 atau Access Denied.

---

## Admin Mengakses Customer

Pada project ini Administrator diperbolehkan mengakses Dashboard Customer hanya jika memang diperlukan. Kebijakan ini dapat disesuaikan pada tahap implementasi.

---

# Best Practice

Selama pengembangan gunakan beberapa aturan berikut.

* Jangan menggunakan angka sebagai role.
* Gunakan nama role yang mudah dipahami.
* Gunakan middleware untuk membatasi akses.
* Jangan melakukan pengecekan role langsung di Blade jika dapat dilakukan di middleware.
* Pisahkan route Admin dan Customer.
* Pisahkan controller berdasarkan area aplikasi.
* Pisahkan view berdasarkan area aplikasi.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration role berhasil dibuat.
* [ ] Kolom role berhasil ditambahkan.
* [ ] Middleware Role berhasil dibuat.
* [ ] Middleware berhasil didaftarkan.
* [ ] Route Admin berhasil diamankan.
* [ ] Route Customer berhasil diamankan.
* [ ] Redirect setelah login berhasil.
* [ ] Seeder Administrator berhasil dibuat.
* [ ] Login Admin berhasil.
* [ ] Login Customer berhasil.
* [ ] Guest tidak dapat mengakses Dashboard.
* [ ] Customer tidak dapat mengakses halaman Admin.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Authentication Laravel Breeze
* Role Administrator
* Role Customer
* Middleware Role
* Dashboard terpisah
* Route terpisah
* Controller terpisah
* View terpisah
* Administrator default melalui Seeder

Dengan struktur ini aplikasi siap dikembangkan menjadi sistem penjualan buku yang memiliki tiga area utama, yaitu Public Website, Customer Area, dan Admin Dashboard.

---

# Tahap Selanjutnya

Pada modul **04 - Layout Bootstrap** kita akan mulai mengganti tampilan bawaan Laravel Breeze dengan **Bootstrap 5**. Seluruh layout aplikasi akan disusun menggunakan template yang konsisten, lengkap dengan Navbar, Sidebar Admin, Sidebar Customer, Footer, Breadcrumb, serta struktur Blade (`layouts`, `partials`, dan `components`) yang akan digunakan pada seluruh modul berikutnya.
