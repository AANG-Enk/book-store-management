# 17 - Testing

# 🧪 Pengujian Sistem (Testing)

Pengujian merupakan tahapan untuk memastikan seluruh fitur pada Sistem Informasi Toko Buku berjalan sesuai dengan kebutuhan pengguna. Pada modul ini mahasiswa akan melakukan pengujian menggunakan metode **Black Box Testing** serta **User Acceptance Testing (UAT)**.

Hasil pengujian nantinya dapat digunakan sebagai bagian dari Bab IV pada laporan Tugas Akhir.

---

# Tujuan Pembelajaran

Setelah menyelesaikan modul ini mahasiswa diharapkan mampu:

* Melakukan Black Box Testing
* Melakukan User Acceptance Testing (UAT)
* Menguji seluruh fitur aplikasi
* Mendokumentasikan hasil pengujian
* Memastikan aplikasi siap digunakan

---

# Jenis Pengujian

Pengujian yang digunakan.

* Black Box Testing
* User Acceptance Testing (UAT)

Tidak diwajibkan menggunakan Unit Test karena fokus proyek adalah implementasi aplikasi.

---

# Black Box Testing

Black Box Testing dilakukan dengan menguji fungsi aplikasi tanpa melihat kode program.

Yang diuji adalah:

* Input
* Proses
* Output

---

# Modul yang Diuji

Lakukan pengujian pada seluruh modul.

* Login
* Register
* Dashboard
* Master Kategori
* Master Buku
* Master Supplier
* Keranjang
* Checkout
* Pembayaran
* Manajemen Pesanan
* Laporan
* Profile

---

# Contoh Tabel Black Box

| No | Fitur        | Skenario Pengujian     | Hasil yang Diharapkan | Status |
| -- | ------------ | ---------------------- | --------------------- | ------ |
| 1  | Login        | Email & Password benar | Berhasil Login        | ✅      |
| 2  | Login        | Password salah         | Muncul pesan error    | ✅      |
| 3  | Tambah Buku  | Data lengkap           | Data tersimpan        | ✅      |
| 4  | Checkout     | Keranjang kosong       | Tidak dapat checkout  | ✅      |
| 5  | Upload Bukti | File valid             | Bukti tersimpan       | ✅      |

Tambahkan seluruh fitur sesuai aplikasi yang dibuat.

---

# Pengujian Login

Uji beberapa kondisi.

* Email benar
* Password benar
* Password salah
* Email tidak terdaftar
* Akun tidak aktif (jika diterapkan)

---

# Pengujian CRUD

Lakukan pengujian pada seluruh master data.

* Tambah
* Edit
* Hapus
* Cari
* Pagination

---

# Pengujian Keranjang

Pastikan.

* Tambah buku berhasil.
* Update quantity berhasil.
* Hapus item berhasil.
* Total berubah otomatis.
* Tidak bisa melebihi stok.

---

# Pengujian Checkout

Pastikan.

* Keranjang berubah menjadi pesanan.
* Invoice terbentuk.
* Order Item tersimpan.
* Total pembayaran sesuai.

---

# Pengujian Pembayaran

Pastikan.

* Upload bukti berhasil.
* File tersimpan.
* Status berubah menjadi Menunggu Verifikasi.
* Admin dapat memverifikasi pembayaran.

---

# Pengujian Pesanan

Pastikan perubahan status berjalan.

* Pending
* Diproses
* Dikirim
* Selesai
* Dibatalkan

---

# Pengujian Laporan

Pastikan.

* Filter berjalan.
* Export Excel berhasil.
* Export PDF berhasil.
* Grafik tampil dengan benar.

---

# Pengujian Profile

Pastikan.

* Edit profile berhasil.
* Upload foto berhasil.
* Ganti password berhasil.
* Password lama harus benar.

---

# Validasi Form

Uji seluruh validasi.

Contoh.

* Field kosong
* Email tidak valid
* Password kurang dari 8 karakter
* Upload file bukan gambar
* Upload file terlalu besar

Semua harus menghasilkan pesan validasi yang sesuai.

---

# User Acceptance Testing (UAT)

UAT dilakukan oleh pengguna akhir untuk memastikan aplikasi memenuhi kebutuhan.

Responden dapat berupa.

* Dosen
* Teman
* Pemilik Toko Buku (simulasi)
* Mahasiswa lain

---

# Contoh Tabel UAT

| No | Pernyataan                 | SS | S | N | TS | STS |
| -- | -------------------------- | -- | - | - | -- | --- |
| 1  | Tampilan aplikasi menarik  | □  | □ | □ | □  | □   |
| 2  | Menu mudah dipahami        | □  | □ | □ | □  | □   |
| 3  | Fitur berjalan dengan baik | □  | □ | □ | □  | □   |
| 4  | Proses checkout mudah      | □  | □ | □ | □  | □   |
| 5  | Laporan mudah digunakan    | □  | □ | □ | □  | □   |

Gunakan skala Likert 1–5.

---

# Dokumentasi Pengujian

Simpan screenshot.

* Login
* Dashboard
* CRUD Buku
* Checkout
* Pembayaran
* Laporan
* Profile

Dokumentasi ini dapat dimasukkan ke Bab IV laporan.

---

# Pengujian Browser

Minimal lakukan pengujian pada.

* Google Chrome
* Microsoft Edge
* Mozilla Firefox

Pastikan tampilan Bootstrap tetap responsif.

---

# Pengujian Responsive

Uji tampilan pada.

* Desktop
* Tablet
* Smartphone

Pastikan seluruh menu masih dapat digunakan dengan baik.

---

# Daftar Bug

Catat jika ditemukan bug.

| No | Bug    | Penyebab | Solusi           |
| -- | ------ | -------- | ---------------- |
| 1  | Contoh | Contoh   | Sudah diperbaiki |

Jika tidak ditemukan bug, tuliskan bahwa seluruh fungsi utama berjalan sesuai hasil pengujian.

---

# Best Practice

Gunakan aturan berikut.

* Uji setiap fitur sebelum melanjutkan ke modul berikutnya.
* Dokumentasikan hasil pengujian dalam bentuk tabel.
* Simpan screenshot sebagai bukti implementasi.
* Lakukan pengujian pada beberapa browser.
* Pastikan semua validasi form berfungsi.
* Uji hak akses Admin dan Customer secara terpisah.

---

# Checklist

Pastikan seluruh poin berikut telah selesai.

* [ ] Black Box Testing selesai.
* [ ] Pengujian Login selesai.
* [ ] Pengujian CRUD selesai.
* [ ] Pengujian Keranjang selesai.
* [ ] Pengujian Checkout selesai.
* [ ] Pengujian Pembayaran selesai.
* [ ] Pengujian Pesanan selesai.
* [ ] Pengujian Laporan selesai.
* [ ] Pengujian Profile selesai.
* [ ] Validasi Form selesai.
* [ ] UAT selesai.
* [ ] Dokumentasi Screenshot selesai.
* [ ] Pengujian Browser selesai.
* [ ] Pengujian Responsive selesai.

---

# Hasil Akhir Tahap

Setelah modul ini selesai aplikasi telah:

* Lulus Black Box Testing
* Memiliki hasil User Acceptance Testing (UAT)
* Memiliki dokumentasi hasil pengujian
* Memiliki bukti screenshot implementasi
* Memastikan seluruh fitur berjalan sesuai kebutuhan

Dokumen pengujian ini dapat langsung digunakan sebagai lampiran maupun bagian dari Bab IV pada laporan Tugas Akhir.

---

# Tahap Selanjutnya

## 18 - Deployment & Finalisasi Project

Modul terakhir berfokus pada persiapan aplikasi untuk lingkungan produksi dan presentasi Tugas Akhir, meliputi:

* Konfigurasi `.env` Production
* Optimasi Laravel (`config:cache`, `route:cache`, `view:cache`)
* Pembuatan symbolic link storage
* Backup database
* Deployment ke Hosting Shared/VPS
* Penyusunan Manual Book
* Penyusunan Dokumen Instalasi
* Persiapan Presentasi dan Demo Sidang
* Checklist final seluruh fitur aplikasi

Setelah modul ini selesai, Sistem Informasi Toko Buku siap dipublikasikan, dipresentasikan, dan digunakan sebagai proyek akhir mahasiswa.
