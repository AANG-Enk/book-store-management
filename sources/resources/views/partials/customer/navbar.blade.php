<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.dashboard') }}">
            <i class="bi bi-book-half me-2 text-primary"></i>
            <span>BookStore</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#customerNavbar"
            aria-controls="customerNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="customerNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a
                        href="{{ route('customer.dashboard') }}"
                        class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active fw-semibold text-primary' : '' }}"
                    >
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="{{ route('books.index') }}"
                        class="nav-link {{ request()->routeIs('books.*') ? 'active fw-semibold text-primary' : '' }}"
                    >
                        Katalog
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link disabled" aria-disabled="true">Keranjang</a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link disabled" aria-disabled="true">Pesanan</a>
                </li>
            </ul>

            <div class="dropdown">
                <button
                    class="btn btn-light border dropdown-toggle btn-sm"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <i class="bi bi-person-circle me-1"></i>
                    {{ auth()->user()->name }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                            <i class="bi bi-house me-2"></i>Beranda
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2"></i>Profil
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
