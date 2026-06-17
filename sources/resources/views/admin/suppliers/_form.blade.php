@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Nama Supplier</label>
        <input
            id="name"
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $supplier->name ?? '') }}"
            required
            maxlength="150"
            autofocus
            placeholder="Contoh: Gramedia Distributor"
        >

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label">No. Telepon</label>
        <input
            id="phone"
            type="text"
            name="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $supplier->phone ?? '') }}"
            maxlength="30"
            placeholder="Contoh: 081234567890"
        >

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $supplier->email ?? '') }}"
            maxlength="150"
            placeholder="supplier@email.com"
        >

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="address" class="form-label">Alamat</label>
        <textarea
            id="address"
            name="address"
            rows="4"
            class="form-control @error('address') is-invalid @enderror"
            maxlength="1000"
            placeholder="Alamat lengkap supplier"
        >{{ old('address', $supplier->address ?? '') }}</textarea>

        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="notes" class="form-label">Catatan</label>
        <textarea
            id="notes"
            name="notes"
            rows="3"
            class="form-control @error('notes') is-invalid @enderror"
            maxlength="1000"
            placeholder="Catatan tambahan, opsional"
        >{{ old('notes', $supplier->notes ?? '') }}</textarea>

        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input
                id="is_active"
                type="checkbox"
                name="is_active"
                value="1"
                class="form-check-input"
                @checked(old('is_active', $supplier->is_active ?? true))
            >
            <label for="is_active" class="form-check-label">
                Supplier aktif
            </label>
        </div>

        @error('is_active')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>
        Simpan
    </button>

    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>
