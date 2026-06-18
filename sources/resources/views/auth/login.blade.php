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
                    <p class="text-secondary mt-2 mb-0">Masuk ke akun kamu</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required
                            autofocus
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
                            autocomplete="current-password"
                        >

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="form-check-input"
                                name="remember"
                            >
                            <label class="form-check-label" for="remember_me">
                                Ingat saya
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="small" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-secondary small">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="small fw-semibold">
                        Daftar sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
