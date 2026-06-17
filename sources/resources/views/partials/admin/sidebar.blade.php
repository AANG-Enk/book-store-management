<aside class="admin-sidebar bg-dark text-white">
    <div class="p-3 border-bottom border-secondary">
        <a href="{{ route('admin.dashboard') }}" class="text-white fw-bold fs-5 d-flex align-items-center">
            <i class="bi bi-speedometer2 me-2"></i>
            <span>Admin</span>
        </a>
        <div class="small text-white-50 mt-1">BookStore Panel</div>
    </div>

    <nav class="p-3">
        <div class="small text-white-50 text-uppercase mb-2">Menu Utama</div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <i class="bi bi-house-door"></i>
            <span>Dashboard</span>
        </a>

        <div class="small text-white-50 text-uppercase mt-4 mb-2">Master Data</div>

        <a href="#" class="admin-nav-link disabled" aria-disabled="true">
            <i class="bi bi-tags"></i>
            <span>Kategori Buku</span>
        </a>

        <a href="#" class="admin-nav-link disabled" aria-disabled="true">
            <i class="bi bi-book"></i>
            <span>Buku</span>
        </a>

        <a href="#" class="admin-nav-link disabled" aria-disabled="true">
            <i class="bi bi-truck"></i>
            <span>Supplier</span>
        </a>

        <div class="small text-white-50 text-uppercase mt-4 mb-2">Transaksi</div>

        <a href="#" class="admin-nav-link disabled" aria-disabled="true">
            <i class="bi bi-bag-check"></i>
            <span>Pesanan</span>
        </a>

        <a href="#" class="admin-nav-link disabled" aria-disabled="true">
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>

        <div class="small text-white-50 text-uppercase mt-4 mb-2">Laporan</div>

        <a href="#" class="admin-nav-link disabled" aria-disabled="true">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan</span>
        </a>
    </nav>
</aside>
