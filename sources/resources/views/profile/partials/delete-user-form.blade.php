<section>
    <div class="mb-4">
        <h2 class="h5 fw-bold text-danger mb-1">Hapus Akun</h2>
        <p class="text-secondary mb-0">
            Setelah akun dihapus, semua data akun akan dihapus secara permanen.
        </p>
    </div>

    <div class="alert alert-danger" role="alert">
        <div class="fw-semibold mb-1">Tindakan ini tidak bisa dibatalkan.</div>
        <div class="small">
            Masukkan password untuk mengonfirmasi penghapusan akun.
        </div>
    </div>

    <button
        type="button"
        class="btn btn-outline-danger"
        data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletionModal"
    >
        Hapus Akun
    </button>

    <div
        class="modal fade"
        id="confirmUserDeletionModal"
        tabindex="-1"
        aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <form method="POST" action="{{ route('profile.destroy') }}" class="modal-content">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h3 class="modal-title h5 fw-bold" id="confirmUserDeletionModalLabel">
                        Konfirmasi Hapus Akun
                    </h3>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>

                <div class="modal-body">
                    <p class="text-secondary">
                        Apakah kamu yakin ingin menghapus akun ini? Masukkan password untuk melanjutkan.
                    </p>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >

                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@if ($errors->userDeletion->isNotEmpty())
    @push('scripts')
        <script>
            const deleteAccountModal = new bootstrap.Modal(
                document.getElementById('confirmUserDeletionModal')
            );

            deleteAccountModal.show();
        </script>
    @endpush
@endif
