@csrf

<div class="mb-3">
    <label for="name" class="form-label">Nama Kategori</label>
    <input
        id="name"
        type="text"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $category->name ?? '') }}"
        required
        maxlength="150"
        autofocus
        placeholder="Contoh: Novel, Komik, Pendidikan"
    >

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Deskripsi</label>
    <textarea
        id="description"
        name="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
        maxlength="1000"
        placeholder="Deskripsi singkat kategori buku"
    >{{ old('description', $category->description ?? '') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <div class="form-text">
        Opsional. Maksimal 1000 karakter.
    </div>
</div>

<div class="mb-4">
    <div class="form-check form-switch">
        <input
            id="is_active"
            type="checkbox"
            name="is_active"
            value="1"
            class="form-check-input"
            @checked(old('is_active', $category->is_active ?? true))
        >
        <label for="is_active" class="form-check-label">
            Kategori aktif
        </label>
    </div>

    @error('is_active')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>
        Simpan
    </button>

    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>
