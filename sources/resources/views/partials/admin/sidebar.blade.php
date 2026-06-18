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

        <a
            href="{{ route('admin.categories.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
        >
            <i class="bi bi-tags"></i>
            <span>Kategori Buku</span>
        </a>

        <a
            href="{{ route('admin.books.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}"
        >
            <i class="bi bi-book"></i>
            <span>Buku</span>
        </a>

        <a
            href="{{ route('admin.suppliers.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}"
        >
            <i class="bi bi-truck"></i>
            <span>Supplier</span>
        </a>

        <div class="small text-white-50 text-uppercase mt-4 mb-2">Transaksi</div>

        <a
            href="{{ route('admin.orders.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
        >
            <i class="bi bi-bag-check"></i>
            <span>Pesanan</span>
        </a>

        <a
            href="{{ route('admin.payments.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
        >
            <i class="bi bi-credit-card"></i>
            <span>Pembayaran</span>
        </a>

        <a
            href="{{ route('admin.contact-messages.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}"
        >
            <i class="bi bi-envelope"></i>
            <span>Pesan Kontak</span>
        </a>

        <div class="small text-white-50 text-uppercase mt-4 mb-2">Laporan</div>

        <a
            href="{{ route('admin.reports.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
        >
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan</span>
        </a>
    </nav>
</aside>
