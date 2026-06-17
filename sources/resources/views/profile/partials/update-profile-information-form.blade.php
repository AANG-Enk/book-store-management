<section>
    <div class="mb-4">
        <h2 class="h5 fw-bold mb-1">Informasi Profil</h2>
        <p class="text-secondary mb-0">
            Perbarui nama dan alamat email akun kamu.
        </p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
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
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning" role="alert">
                <div class="fw-semibold mb-1">Email belum diverifikasi.</div>

                <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <button
                    form="send-verification"
                    type="submit"
                    class="btn btn-link p-0"
                >
                    Kirim ulang email verifikasi.
                </button>

                @if (session('status') === 'verification-link-sent')
                    <div class="small text-success mt-2">
                        Link verifikasi baru sudah dikirim ke email kamu.
                    </div>
                @endif
            </div>
        @endif

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small">
                    Profil berhasil diperbarui.
                </span>
            @endif
        </div>
    </form>
</section>
