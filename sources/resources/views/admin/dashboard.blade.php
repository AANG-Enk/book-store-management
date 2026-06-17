<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookStore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>Admin BookStore
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

    <main class="container-fluid py-4">
        <div class="mb-4">
            <h1 class="h3 fw-bold">Dashboard Admin</h1>
            <p class="text-secondary mb-0">
                Ringkasan data toko buku akan tampil di halaman ini.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary mb-1">Total Buku</p>
                        <h2 class="h4 fw-bold mb-0">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary mb-1">Total Customer</p>
                        <h2 class="h4 fw-bold mb-0">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary mb-1">Total Pesanan</p>
                        <h2 class="h4 fw-bold mb-0">0</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <p class="text-secondary mb-1">Pembayaran Pending</p>
                        <h2 class="h4 fw-bold mb-0">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
