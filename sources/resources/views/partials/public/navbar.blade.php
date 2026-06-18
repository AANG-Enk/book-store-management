<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-book-half me-2 text-primary"></i>
            <span>BookStore</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#publicNavbar"
            aria-controls="publicNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="publicNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold text-primary' : '' }}"
                        href="{{ route('home') }}"
                    >
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('books.*') ? 'active fw-semibold text-primary' : '' }}"
                        href="{{ route('books.index') }}"
                    >
                        Katalog
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('about') ? 'active fw-semibold text-primary' : '' }}"
                        href="{{ route('about') }}"
                    >
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('contact') ? 'active fw-semibold text-primary' : '' }}"
                        href="{{ route('contact') }}"
                    >
                        Kontak
                    </a>
                </li>
            </ul>

            <div class="d-flex gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
