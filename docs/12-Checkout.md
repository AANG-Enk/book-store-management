# 12 - Checkout

# 💳 Checkout & Pembuatan Pesanan

Checkout merupakan proses mengubah data Keranjang Belanja menjadi sebuah transaksi atau pesanan yang siap dibayar oleh Customer.

Pada modul ini Customer akan mengisi data penerima, alamat pengiriman, memilih metode pembayaran, kemudian sistem akan membuat Invoice secara otomatis.

Karena project ini menggunakan **Pembayaran Manual**, maka setelah Checkout Customer hanya perlu melakukan transfer bank dan mengunggah bukti pembayaran pada modul berikutnya.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Membuat tabel Orders
* Membuat tabel Order Items
* Membuat nomor Invoice otomatis
* Memindahkan data Cart menjadi Order
* Menyimpan alamat pengiriman
* Menghitung total pembayaran
* Mengubah status pesanan
* Mengosongkan Cart setelah Checkout

---

# Konsep Checkout

Alur transaksi.

```text
Keranjang

↓

Checkout

↓

Order

↓

Transfer Bank

↓

Upload Bukti

↓

Verifikasi Admin

↓

Pesanan Selesai
```

---

# Struktur Database

Buat dua tabel.

```text
orders

order_items
```

---

# Tabel orders

| Field          | Tipe      |
| -------------- | --------- |
| id             | bigint    |
| invoice_number | varchar   |
| user_id        | bigint    |
| recipient_name | varchar   |
| phone          | varchar   |
| address        | text      |
| city           | varchar   |
| postal_code    | varchar   |
| notes          | text      |
| total_item     | integer   |
| total_quantity | integer   |
| subtotal       | decimal   |
| shipping_cost  | decimal   |
| discount       | decimal   |
| grand_total    | decimal   |
| payment_method | varchar   |
| payment_status | enum      |
| order_status   | enum      |
| created_at     | timestamp |
| updated_at     | timestamp |

---

# Tabel order_items

| Field      | Tipe      |
| ---------- | --------- |
| id         | bigint    |
| order_id   | bigint    |
| book_id    | bigint    |
| book_title | varchar   |
| price      | decimal   |
| quantity   | integer   |
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

Order

1

↓

∞

Order Item

∞

↓

1

Book
```

---

# Nomor Invoice

Nomor Invoice dibuat otomatis.

Contoh.

```text
INV-20260617-0001

INV-20260617-0002

INV-20260617-0003
```

Format.

```text
INV-TANGGAL-NOMOR
```

Nomor harus unik.

---

# Status Pembayaran

Gunakan Enum.

```text
Pending

Waiting Confirmation

Paid

Rejected
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

---

# Metode Pembayaran

Untuk saat ini hanya tersedia.

```text
Transfer Bank
```

Namun struktur database disiapkan agar nantinya dapat ditambah.

* Midtrans
* QRIS
* E-Wallet
* Virtual Account

Tanpa mengubah struktur tabel.

---

# Halaman Checkout

Customer mengisi data berikut.

* Nama Penerima
* Nomor Telepon
* Kota
* Kode Pos
* Alamat Lengkap
* Catatan Pesanan (Opsional)

Di bawah form tampilkan Ringkasan Belanja.

---

# Ringkasan Belanja

Tampilkan.

* Total Item
* Total Buku
* Subtotal
* Ongkir
* Diskon
* Grand Total

Pada versi pertama.

```text
Ongkir = Rp0

Diskon = Rp0
```

---

# Informasi Transfer

Setelah Checkout berhasil tampilkan informasi rekening.

Contoh.

```text
Bank BCA

1234567890

a.n. Toko Buku Digital
```

Data rekening sebaiknya berasal dari tabel Setting agar mudah diubah melalui Admin.

---

# Proses Checkout

Saat tombol.

```text
Buat Pesanan
```

ditekan, sistem melakukan proses berikut.

1. Validasi data Customer.
2. Validasi stok buku.
3. Membuat Order.
4. Membuat Order Item.
5. Mengurangi stok buku.
6. Menghapus isi Cart.
7. Menghasilkan Invoice.
8. Mengarahkan Customer ke halaman Detail Pesanan.

---

# Validasi

Periksa.

* Keranjang tidak kosong.
* Semua stok masih tersedia.
* Data penerima lengkap.
* Customer sudah login.

---

# Snapshot Data

Harga dan judul buku pada `order_items` disimpan sebagai snapshot.

Tujuannya agar histori transaksi tidak berubah walaupun data buku diperbarui di kemudian hari.

---

# Halaman Detail Pesanan

Tampilkan.

* Nomor Invoice
* Tanggal
* Daftar Buku
* Jumlah
* Harga
* Subtotal
* Grand Total
* Status Pembayaran
* Status Pesanan
* Informasi Transfer Bank

Tambahkan tombol.

```text
Upload Bukti Pembayaran
```

---

# Halaman Riwayat Pesanan

Customer dapat melihat seluruh transaksi.

Kolom.

* Invoice
* Tanggal
* Total
* Status Pembayaran
* Status Pesanan
* Aksi

Gunakan Pagination.

---

# Admin Dashboard

Admin dapat melihat daftar pesanan.

Kolom.

* Invoice
* Customer
* Total
* Pembayaran
* Status Pesanan
* Tanggal

Admin belum dapat memverifikasi pembayaran pada tahap ini.

---

# Flash Message

Gunakan Session Flash.

Contoh.

* Checkout berhasil.
* Pesanan berhasil dibuat.
* Stok buku tidak mencukupi.
* Keranjang kosong.

---

# Best Practice

Gunakan aturan berikut.

* Simpan snapshot data buku ke `order_items`.
* Gunakan transaksi database (`DB::transaction`) saat proses checkout agar data tetap konsisten.
* Gunakan Eloquent Relationship.
* Validasi stok sebelum mengurangi stok.
* Kurangi stok hanya ketika order berhasil dibuat.
* Jangan melakukan query database di Blade.

---

# Persiapan Integrasi Midtrans

Walaupun pembayaran masih manual, siapkan kolom berikut pada tabel `orders`.

* payment_method
* payment_status
* transaction_id (nullable)
* payment_token (nullable)

Kolom tersebut akan digunakan jika suatu saat aplikasi diintegrasikan dengan Midtrans tanpa perlu mengubah struktur database.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Migration Orders selesai.
* [ ] Migration Order Items selesai.
* [ ] Model Order selesai.
* [ ] Model Order Item selesai.
* [ ] Relasi Database selesai.
* [ ] Invoice otomatis berjalan.
* [ ] Checkout berhasil.
* [ ] Cart berpindah menjadi Order.
* [ ] Cart dikosongkan.
* [ ] Stok buku berkurang.
* [ ] Halaman Detail Pesanan selesai.
* [ ] Riwayat Pesanan selesai.
* [ ] Informasi Transfer Bank tampil.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah memiliki:

* Tabel `orders`
* Tabel `order_items`
* Sistem Invoice Otomatis
* Checkout Customer
* Snapshot Data Transaksi
* Pengurangan Stok Buku
* Riwayat Pesanan
* Detail Pesanan
* Informasi Transfer Bank
* Struktur database siap untuk integrasi Midtrans

Tahap ini menandai bahwa alur transaksi dari pemilihan buku hingga terbentuknya pesanan telah selesai.

---

# Tahap Selanjutnya

Pada modul **13 - Upload Bukti Pembayaran & Verifikasi Admin**, Customer akan mengunggah bukti transfer, sedangkan Admin dapat memeriksa bukti pembayaran, menerima atau menolak pembayaran, mengubah status transaksi, serta mengelola proses hingga pesanan dinyatakan selesai.
