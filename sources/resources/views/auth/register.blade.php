<x-guest-layout>
    <div class="auth-card">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="d-inline-flex flex-column align-items-center gap-2 text-dark fw-bold fs-4">
                        <span class="auth-brand-mark" aria-hidden="true">
                            <i class="bi bi-book-half"></i>
                        </span>
                        <span>BookStore</span>
                    </a>
                    <p class="text-secondary mt-2 mb-0">Buat akun customer baru</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            required
                            autofocus
                            autocomplete="name"
                        >

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required
                            autocomplete="username"
                        >

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="new-password"
                        >

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            required
                            autocomplete="new-password"
                        >

                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Daftar
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-secondary small">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="small fw-semibold">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
