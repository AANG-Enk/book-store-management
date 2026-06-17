<nav class="navbar navbar-expand bg-white border-bottom admin-topbar">
    <div class="container-fluid">
        <div>
            <div class="fw-semibold">@yield('page_title', 'Dashboard')</div>
            <div class="small text-secondary">Panel administrasi BookStore</div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Lihat Website
            </a>

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
