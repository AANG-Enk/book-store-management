# 02 - Authentication

# 🔐 Authentication dengan Laravel Breeze

Pada tahap ini kita akan mengimplementasikan sistem autentikasi menggunakan **Laravel Breeze**. Laravel Breeze menyediakan fitur login, register, logout, reset password, dan manajemen session dengan struktur kode yang sederhana sehingga cocok untuk proses pembelajaran.

Setelah tahap ini selesai, pengguna sudah dapat melakukan registrasi, login, dan logout. Seluruh pengguna masih memiliki hak akses yang sama, sedangkan pembagian hak akses Admin dan Customer akan dibahas pada modul berikutnya.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Memahami konsep Authentication
* Menginstall Laravel Breeze
* Menggunakan Blade Authentication
* Melakukan Register
* Melakukan Login
* Melakukan Logout
* Memahami middleware auth
* Melindungi halaman menggunakan middleware

---

# Konsep Authentication

Authentication adalah proses untuk memverifikasi identitas pengguna sebelum diberikan akses ke dalam sistem.

Flow authentication pada aplikasi BookStore adalah sebagai berikut:

```text
Guest

↓

Register

↓

Login

↓

Session dibuat

↓

Masuk ke Dashboard

↓

Logout

↓

Session dihapus
```

---

# Menginstall Laravel Breeze

Install package Laravel Breeze.

```bash
composer require laravel/breeze --dev
```

---

# Install Breeze

Jalankan perintah berikut.

```bash
php artisan breeze:install blade
```

Pilih opsi:

```text
Blade with Alpine
```

---

# Install Dependency Frontend

```bash
npm install
```

Kemudian jalankan Vite.

```bash
npm run dev
```

---

# Menjalankan Migration

Laravel Breeze akan menambahkan beberapa migration baru.

Jalankan:

```bash
php artisan migrate
```

---

# Menjalankan Project

Terminal pertama

```bash
php artisan serve
```

Terminal kedua

```bash
npm run dev
```

---

# Struktur Folder Authentication

Setelah Breeze berhasil diinstall, beberapa file baru akan ditambahkan.

```text
app
└── Http
    ├── Controllers
    │   └── Auth

resources
└── views
    └── auth

routes
└── auth.php
```

---

# Route Authentication

Laravel Breeze secara otomatis membuat route berikut.

| Method | URL       | Fungsi           |
| ------ | --------- | ---------------- |
| GET    | /login    | Halaman Login    |
| POST   | /login    | Proses Login     |
| GET    | /register | Halaman Register |
| POST   | /register | Proses Register  |
| POST   | /logout   | Logout           |

---

# Halaman Authentication

Laravel Breeze menyediakan halaman berikut.

* Login
* Register
* Forgot Password
* Reset Password
* Verify Email (opsional)
* Confirm Password

Untuk project ini fitur **Forgot Password** dan **Verify Email** belum akan digunakan, namun tetap dibiarkan karena merupakan bagian dari Laravel Breeze.

---

# Struktur Database

Tabel **users** akan digunakan sebagai tabel utama pengguna.

```text
users

id
name
email
email_verified_at
password
remember_token
created_at
updated_at
```

Pada tahap berikutnya tabel ini akan ditambahkan kolom **role** untuk membedakan Admin dan Customer.

---

# Middleware Authentication

Laravel menyediakan middleware **auth** untuk membatasi akses halaman.

Contoh penggunaan:

```php
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
```

Dengan middleware tersebut, hanya pengguna yang sudah login yang dapat mengakses halaman Dashboard.

---

# Testing Authentication

Lakukan pengujian berikut.

## Register

* Isi nama
* Isi email
* Isi password
* Konfirmasi password
* Klik Register

Pastikan data berhasil masuk ke tabel **users**.

---

## Login

Masukkan:

* Email
* Password

Pastikan berhasil masuk ke halaman Dashboard.

---

## Logout

Klik tombol Logout.

Pastikan pengguna kembali menjadi Guest.

---

# Struktur Folder Setelah Authentication

```text
resources

views
├── auth
├── profile
├── dashboard.blade.php

routes
├── web.php
├── auth.php
```

---

# Catatan

Pada tahap ini Dashboard masih menggunakan halaman bawaan Laravel Breeze. Tampilan dashboard akan diganti menggunakan Bootstrap pada modul berikutnya.

Selain itu seluruh pengguna masih dianggap memiliki hak akses yang sama.

---

# Best Practice

Beberapa praktik yang disarankan selama pengembangan:

* Jangan mengubah file inti Laravel Breeze jika tidak diperlukan.
* Gunakan middleware `auth` untuk melindungi halaman.
* Simpan logika bisnis di Controller atau Service, bukan di Blade.
* Selalu gunakan password yang telah di-hash oleh Laravel.
* Jangan menyimpan password dalam bentuk teks biasa.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Laravel Breeze berhasil diinstall.
* [ ] Authentication berhasil dibuat.
* [ ] Halaman Login dapat diakses.
* [ ] Halaman Register dapat diakses.
* [ ] Register berhasil menyimpan data.
* [ ] Login berhasil.
* [ ] Logout berhasil.
* [ ] Middleware auth berhasil melindungi Dashboard.

---

# Hasil Akhir Tahap

Setelah modul ini selesai, aplikasi telah memiliki fitur:

* Sistem Register
* Sistem Login
* Sistem Logout
* Session Authentication
* Middleware Authentication
* Dashboard bawaan Laravel Breeze

Aplikasi kini telah siap untuk dikembangkan lebih lanjut dengan sistem Role & Permission.

---

# Tahap Selanjutnya

Pada modul **03 - Role & Permission** kita akan memisahkan hak akses antara **Administrator** dan **Customer**, menambahkan kolom `role` pada tabel `users`, membuat middleware role, serta mengarahkan pengguna ke dashboard sesuai dengan perannya setelah berhasil login.
