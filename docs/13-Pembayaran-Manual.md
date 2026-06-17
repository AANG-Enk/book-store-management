# 13 - Pembayaran Manual

# 🏦 Upload Bukti Pembayaran & Verifikasi Admin

Setelah Customer berhasil melakukan Checkout, sistem akan menampilkan informasi rekening tujuan transfer. Customer kemudian melakukan transfer secara manual dan mengunggah bukti pembayaran melalui halaman Detail Pesanan.

Selanjutnya Admin akan memverifikasi bukti transfer tersebut sebelum pesanan diproses lebih lanjut.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Mengunggah bukti pembayaran
* Menyimpan data pembayaran
* Melakukan validasi file upload
* Menampilkan bukti pembayaran
* Membuat halaman verifikasi Admin
* Mengubah status pembayaran
* Mengubah status pesanan

---

# Konsep Pembayaran

Alur pembayaran.

```text
Checkout

↓

Transfer Bank

↓

Upload Bukti

↓

Menunggu Verifikasi

↓

Admin Verifikasi

↓

Pembayaran Diterima

↓

Pesanan Diproses
```

---

# Struktur Database

Buat tabel baru.

```text
payments
```

---

# Tabel payments

| Field          | Tipe                |
| -------------- | ------------------- |
| id             | bigint              |
| order_id       | bigint              |
| payment_date   | datetime            |
| amount         | decimal             |
| bank_name      | varchar             |
| sender_name    | varchar             |
| account_number | varchar             |
| proof_image    | varchar             |
| notes          | text                |
| status         | enum                |
| verified_by    | bigint (nullable)   |
| verified_at    | datetime (nullable) |
| created_at     | timestamp           |
| updated_at     | timestamp           |

---

# Relasi Database

```text
Order

1

↓

1

Payment

↓

Verified By

↓

Admin(User)
```

Satu pesanan memiliki satu data pembayaran.

---

# Status Pembayaran

Gunakan Enum.

```text
Pending

Waiting Verification

Approved

Rejected
```

---

# Struktur Folder

```text
app
├── Models
│   └── Payment.php
│
├── Http
│   └── Controllers
│       ├── Customer
│       │   └── PaymentController.php
│       │
│       └── Admin
│           └── PaymentController.php
│
resources
└── views
    ├── customer
    │   └── payment
    │       └── upload.blade.php
    │
    └── admin
        └── payments
            ├── index.blade.php
            └── show.blade.php
```

---

# Halaman Customer

Menu.

```text
Upload Bukti Pembayaran
```

Field.

* Nama Pengirim
* Nama Bank
* Nomor Rekening
* Nominal Transfer
* Tanggal Transfer
* Catatan (Opsional)
* Upload Bukti Transfer

---

# Upload Bukti

Gunakan Laravel Storage.

Lokasi.

```text
storage/app/public/payments
```

File yang diperbolehkan.

* JPG
* JPEG
* PNG

Ukuran maksimal.

```text
2 MB
```

Nama file dibuat unik menggunakan timestamp atau UUID.

---

# Validasi

Field yang wajib.

| Field          | Rule              |
| -------------- | ----------------- |
| sender_name    | required          |
| bank_name      | required          |
| account_number | required          |
| amount         | required, numeric |
| payment_date   | required          |
| proof_image    | required, image   |

---

# Halaman Detail Pesanan

Setelah bukti diunggah tampilkan.

* Foto Bukti Transfer
* Nama Pengirim
* Nama Bank
* Nominal Transfer
* Status Pembayaran

Jika status masih **Waiting Verification**, Customer tidak dapat mengunggah ulang kecuali pembayaran ditolak oleh Admin.

---

# Halaman Admin

Menu.

```text
Verifikasi Pembayaran
```

Gunakan Bootstrap Table.

Kolom.

* Invoice
* Customer
* Nominal
* Bank
* Status
* Tanggal
* Aksi

---

# Detail Pembayaran

Admin dapat melihat.

* Informasi Customer
* Detail Pesanan
* Bukti Transfer ukuran penuh
* Nominal Transfer
* Catatan Customer

Tambahkan tombol.

```text
Terima Pembayaran
```

dan

```text
Tolak Pembayaran
```

---

# Verifikasi Pembayaran

Jika Admin menekan.

```text
Terima Pembayaran
```

Maka sistem melakukan.

* Status Payment → Approved
* Status Order Payment → Paid
* Status Order → Diproses
* Simpan Admin yang memverifikasi
* Simpan tanggal verifikasi

---

# Penolakan Pembayaran

Jika pembayaran ditolak.

Status.

```text
Payment

↓

Rejected
```

Order.

```text
Payment Status

↓

Rejected
```

Customer dapat mengunggah ulang bukti pembayaran.

Admin wajib mengisi alasan penolakan.

Contoh.

```text
Nominal transfer tidak sesuai.
```

atau

```text
Bukti transfer kurang jelas.
```

---

# Penyimpanan File

Gunakan Laravel Storage.

Struktur.

```text
storage

└── app

    └── public

        └── payments
```

Gunakan perintah.

```bash
php artisan storage:link
```

agar file dapat diakses melalui browser.

---

# Flash Message

Contoh.

* Bukti pembayaran berhasil diunggah.
* Pembayaran berhasil diverifikasi.
* Pembayaran ditolak.
* File tidak valid.

Gunakan Bootstrap Alert.

---

# Dashboard Admin

Tambahkan Card baru.

```text
Menunggu Verifikasi

12 Pembayaran
```

Klik card akan menuju halaman daftar pembayaran.

---

# Dashboard Customer

Tambahkan informasi.

```text
Status Pembayaran

Waiting Verification
```

atau.

```text
Approved
```

Status ditampilkan menggunakan Badge Bootstrap.

---

# Persiapan Midtrans

Walaupun masih menggunakan transfer manual, buat struktur agar mudah diintegrasikan.

Pada tabel `payments` tambahkan field nullable.

* transaction_id
* payment_gateway
* gateway_response

Kolom ini belum digunakan tetapi akan berguna ketika beralih ke Midtrans.

---

# Best Practice

Gunakan aturan berikut.

* Simpan file menggunakan Laravel Storage.
* Validasi tipe file.
* Gunakan nama file unik.
* Jangan menyimpan file di folder `public` secara langsung.
* Gunakan relasi Eloquent.
* Hindari logika bisnis di Blade.
* Pisahkan proses upload dan proses verifikasi pada Controller yang berbeda.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration Payment selesai.
* [ ] Model Payment selesai.
* [ ] Relasi Order → Payment selesai.
* [ ] Upload Bukti berjalan.
* [ ] Validasi Upload berjalan.
* [ ] Penyimpanan File menggunakan Storage.
* [ ] Halaman Detail Pembayaran selesai.
* [ ] Halaman Verifikasi Admin selesai.
* [ ] Approve Pembayaran berjalan.
* [ ] Reject Pembayaran berjalan.
* [ ] Customer dapat upload ulang jika ditolak.
* [ ] Dashboard menampilkan status pembayaran.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Tabel `payments`
* Upload Bukti Pembayaran
* Penyimpanan File dengan Laravel Storage
* Halaman Detail Pembayaran
* Verifikasi Pembayaran oleh Admin
* Persetujuan dan Penolakan Pembayaran
* Riwayat Status Pembayaran
* Dashboard Monitoring Pembayaran
* Struktur siap untuk integrasi Midtrans

Dengan selesainya modul ini, alur transaksi dari Checkout hingga pembayaran telah lengkap menggunakan metode transfer bank manual.

---

# Tahap Selanjutnya

Pada modul **14 - Manajemen Pesanan (Order Management)** Admin akan mengelola seluruh pesanan yang telah dibayar, mengubah status menjadi **Diproses**, **Dikirim**, atau **Selesai**, sedangkan Customer dapat memantau perkembangan status pesanannya melalui halaman Riwayat Pesanan.
