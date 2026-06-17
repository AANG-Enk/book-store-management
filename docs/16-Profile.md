# 16 - Profile

# 👤 Profile & Pengaturan Akun

Modul Profile digunakan untuk mengelola informasi akun yang dimiliki oleh pengguna aplikasi. Setiap pengguna, baik Admin maupun Customer, dapat melihat dan memperbarui data pribadinya tanpa harus mengakses database secara langsung.

Selain informasi profil, modul ini juga menyediakan fitur untuk mengganti password, mengubah foto profil, serta melihat aktivitas akun.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat halaman Profile
* Mengubah data diri
* Upload foto profil
* Mengganti password
* Validasi password lama
* Menampilkan riwayat akun
* Menggunakan Laravel Storage

---

# Hak Akses

## Admin

Admin dapat:

* Melihat Profile
* Mengubah Data Profile
* Mengganti Password
* Mengubah Foto

---

## Customer

Customer dapat:

* Melihat Profile
* Mengubah Data Profile
* Mengganti Password
* Mengubah Foto

---

# Struktur Folder

```text
app
├── Http
│   └── Controllers
│       ├── Admin
│       │   └── ProfileController.php
│       │
│       └── Customer
│           └── ProfileController.php
│
resources
└── views
    ├── admin
    │   └── profile
    │       ├── index.blade.php
    │       ├── edit.blade.php
    │       └── password.blade.php
    │
    └── customer
        └── profile
            ├── index.blade.php
            ├── edit.blade.php
            └── password.blade.php
```

---

# Data Profile

Informasi yang dapat diubah.

| Field    | Keterangan            |
| -------- | --------------------- |
| Nama     | Nama lengkap pengguna |
| Email    | Email Login           |
| Nomor HP | Nomor Telepon         |
| Alamat   | Alamat Lengkap        |
| Foto     | Foto Profil           |

---

# Struktur Database

Tambahkan beberapa field pada tabel users.

| Field   | Tipe   |
| ------- | ------ |
| phone   | string |
| address | text   |
| avatar  | string |

Jika sebelumnya belum tersedia, buat migration baru.

---

# Halaman Profile

Gunakan Bootstrap Card.

Informasi yang ditampilkan.

* Foto
* Nama
* Email
* Nomor HP
* Alamat
* Role

Tambahkan tombol.

```text
Edit Profile
```

dan

```text
Ganti Password
```

---

# Edit Profile

Field yang dapat diubah.

* Nama
* Email
* Nomor HP
* Alamat

Email harus unik.

Gunakan validasi Laravel.

---

# Upload Foto

Gunakan Laravel Storage.

Folder penyimpanan.

```text
storage/app/public/profile
```

Atau melalui symbolic link.

```text
public/storage/profile
```

---

# Validasi Upload

Format.

```text
jpg

jpeg

png
```

Ukuran maksimal.

```text
2 MB
```

---

# Menampilkan Foto Default

Jika pengguna belum memiliki foto.

Tampilkan gambar default.

```text
default-user.png
```

---

# Ganti Password

Halaman terdiri dari.

* Password Lama
* Password Baru
* Konfirmasi Password

---

# Validasi Password

Sebelum mengubah password.

Periksa.

* Password lama benar
* Password baru minimal 8 karakter
* Password baru dan konfirmasi harus sama

Password disimpan menggunakan Hash Laravel.

---

# Riwayat Aktivitas

Tambahkan informasi sederhana.

Misalnya.

```text
Tanggal Registrasi

Login Terakhir

Jumlah Pesanan (Customer)

Jumlah Buku Dikelola (Admin)
```

Riwayat login terakhir dapat disiapkan sebagai pengembangan jika belum diimplementasikan.

---

# Navbar

Pada pojok kanan atas tampilkan dropdown.

```text
Nama User

↓

Profile

Ganti Password

Logout
```

Gunakan Bootstrap Dropdown.

---

# Flash Message

Contoh.

* Profile berhasil diperbarui.
* Password berhasil diubah.
* Foto berhasil diperbarui.
* Password lama salah.
* Email sudah digunakan.

---

# Validasi

Pastikan.

* Email unik.
* Nomor HP maksimal 20 karakter.
* Password minimal 8 karakter.
* Foto sesuai format.
* Semua input dibersihkan menggunakan Request Validation.

---

# Best Practice

Gunakan aturan berikut.

* Gunakan Form Request Validation.
* Simpan password menggunakan `Hash::make()`.
* Hapus foto lama ketika pengguna mengunggah foto baru (kecuali foto default).
* Simpan file menggunakan Laravel Storage.
* Jangan menyimpan password dalam bentuk teks biasa.
* Pisahkan halaman Admin dan Customer agar mudah dikembangkan.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Halaman Profile selesai.
* [ ] Edit Profile selesai.
* [ ] Upload Foto selesai.
* [ ] Validasi Upload selesai.
* [ ] Ganti Password selesai.
* [ ] Validasi Password Lama selesai.
* [ ] Foto Default selesai.
* [ ] Dropdown Navbar selesai.
* [ ] Flash Message selesai.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Halaman Profile Admin
* Halaman Profile Customer
* Edit Data Diri
* Upload Foto Profil
* Ganti Password
* Validasi Password Lama
* Foto Profil Default
* Dropdown Profile pada Navbar
* Penyimpanan File menggunakan Laravel Storage

Modul ini melengkapi fitur manajemen akun sehingga setiap pengguna dapat mengelola informasi pribadinya secara mandiri.

---

# Tahap Selanjutnya

## 17 - Deployment & Finalisasi Project

Pada modul terakhir mahasiswa akan mempersiapkan aplikasi agar siap dipresentasikan dan dijalankan di server, meliputi:

* Konfigurasi `.env` Production
* Optimasi Laravel (`config:cache`, `route:cache`, `view:cache`)
* Storage Link
* Backup Database
* Pengujian Black Box
* Pengujian User Acceptance Testing (UAT)
* Deployment ke Hosting atau VPS
* Penyusunan Manual Book
* Persiapan Presentasi dan Sidang Tugas Akhir

Modul ini menjadi tahap penutup yang memastikan aplikasi siap digunakan sebagai produk akhir proyek Tugas Akhir.
