<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - BookStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('customer.dashboard') }}">
                <i class="bi bi-book-half me-2"></i>BookStore
            </a>

            <div class="d-flex align-items-center gap-3">
                <span class="small text-secondary">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="mb-4">
            <h1 class="h3 fw-bold">Dashboard Customer</h1>
            <p class="text-secondary mb-0">
                Selamat datang, {{ auth()->user()->name }}.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bi bi-search fs-2 text-primary"></i>
                        <h2 class="h5 mt-3">Lihat Katalog</h2>
                        <p class="text-secondary">
                            Cari buku berdasarkan kategori dan judul.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm disabled">
                            Segera Dibuat
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bi bi-cart fs-2 text-primary"></i>
                        <h2 class="h5 mt-3">Keranjang</h2>
                        <p class="text-secondary">
                            Simpan buku sebelum melakukan checkout.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm disabled">
                            Segera Dibuat
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bi bi-clock-history fs-2 text-primary"></i>
                        <h2 class="h5 mt-3">Riwayat Pesanan</h2>
                        <p class="text-secondary">
                            Lihat status pesanan dan pembayaran.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm disabled">
                            Segera Dibuat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
