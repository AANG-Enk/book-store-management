<aside class="admin-sidebar text-white" aria-label="Navigasi admin">
    <div class="admin-sidebar-brand p-3 border-bottom border-secondary">
        <a href="{{ route('admin.dashboard') }}" class="text-white fw-bold fs-5 d-flex align-items-center gap-2">
            <span class="brand-logo" aria-hidden="true">
                <i class="bi bi-speedometer2"></i>
            </span>
            <span>Admin</span>
        </a>
        <div class="small text-white-50 mt-2">BookStore Panel</div>
    </div>

    <nav class="p-3">
        <div class="admin-menu-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i><span>Dashboard</span>
        </a>

        <div class="admin-menu-label">Master Data</div>
        <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i><span>Kategori</span>
        </a>
        <a href="{{ route('admin.books.index') }}" class="admin-nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i><span>Buku</span>
        </a>
        <a href="{{ route('admin.suppliers.index') }}" class="admin-nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i><span>Supplier</span>
        </a>

        <div class="admin-menu-label">Transaksi</div>
        <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i><span>Pesanan</span>
        </a>
        <a href="{{ route('admin.payments.index') }}" class="admin-nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i><span>Pembayaran</span>
        </a>

        @php
            $unreadSidebarMessages = \App\Models\ContactMessage::query()
                ->where('is_read', false)
                ->count();
        @endphp
        <a href="{{ route('admin.contact-messages.index') }}" class="admin-nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i><span>Pesan Kontak</span>
            @if ($unreadSidebarMessages > 0)
                <span class="badge text-bg-warning ms-auto">{{ $unreadSidebarMessages }}</span>
            @endif
        </a>

        <div class="admin-menu-label">Laporan</div>
        <a href="{{ route('admin.reports.index') }}" class="admin-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span>
        </a>
    </nav>
</aside>
