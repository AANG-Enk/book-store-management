@csrf

<div class="row g-3">
    <div class="col-md-4">
        <label for="title" class="form-label">Judul Buku</label>
        <input
            id="title"
            type="text"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $book->title ?? '') }}"
            required
            maxlength="200"
            autofocus
            placeholder="Contoh: Laravel untuk Pemula"
        >

        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="category_id" class="form-label">Kategori</label>
        <select
            id="category_id"
            name="category_id"
            class="form-select @error('category_id') is-invalid @enderror"
            required
        >
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected((string) old('category_id', $book->category_id ?? '') === (string) $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="supplier_id" class="form-label">Supplier</label>
        <select
            id="supplier_id"
            name="supplier_id"
            class="form-select @error('supplier_id') is-invalid @enderror"
        >
            <option value="">Tanpa supplier</option>

            @foreach ($suppliers as $supplier)
                <option
                    value="{{ $supplier->id }}"
                    @selected((string) old('supplier_id', $book->supplier_id ?? '') === (string) $supplier->id)
                >
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>

        @error('supplier_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="author" class="form-label">Penulis</label>
        <input
            id="author"
            type="text"
            name="author"
            class="form-control @error('author') is-invalid @enderror"
            value="{{ old('author', $book->author ?? '') }}"
            maxlength="150"
            placeholder="Nama penulis"
        >

        @error('author')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="publisher" class="form-label">Penerbit</label>
        <input
            id="publisher"
            type="text"
            name="publisher"
            class="form-control @error('publisher') is-invalid @enderror"
            value="{{ old('publisher', $book->publisher ?? '') }}"
            maxlength="150"
            placeholder="Nama penerbit"
        >

        @error('publisher')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="publication_year" class="form-label">Tahun Terbit</label>
        <input
            id="publication_year"
            type="number"
            name="publication_year"
            class="form-control @error('publication_year') is-invalid @enderror"
            value="{{ old('publication_year', $book->publication_year ?? '') }}"
            min="1900"
            max="{{ now()->year }}"
            placeholder="{{ now()->year }}"
        >

        @error('publication_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="isbn" class="form-label">ISBN</label>
        <input
            id="isbn"
            type="text"
            name="isbn"
            class="form-control @error('isbn') is-invalid @enderror"
            value="{{ old('isbn', $book->isbn ?? '') }}"
            maxlength="50"
            placeholder="Opsional"
        >

        @error('isbn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="stock" class="form-label">Stok</label>
        <input
            id="stock"
            type="number"
            name="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock', $book->stock ?? 0) }}"
            required
            min="0"
        >

        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="price" class="form-label">Harga</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input
                id="price"
                type="number"
                name="price"
                class="form-control @error('price') is-invalid @enderror"
                value="{{ old('price', isset($book) ? (int) $book->price : 0) }}"
                required
                min="0"
                step="100"
            >

            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="cover_image" class="form-label">Cover Buku</label>
        <input
            id="cover_image"
            type="file"
            name="cover_image"
            class="form-control @error('cover_image') is-invalid @enderror"
            accept="image/png,image/jpeg,image/jpg,image/webp"
        >

        @error('cover_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-text">
            Format jpg, jpeg, png, webp. Maksimal 2MB.
        </div>

        @if (! empty($book?->cover_image))
            <div class="mt-3">
                <img
                    src="{{ $book->cover_url }}"
                    alt="Cover {{ $book->title }}"
                    class="book-cover-preview border"
                >
            </div>
        @endif
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea
            id="description"
            name="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror"
            maxlength="3000"
            placeholder="Deskripsi singkat buku"
        >{{ old('description', $book->description ?? '') }}</textarea>

        @error('description')
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
                @checked(old('is_active', $book->is_active ?? true))
            >
            <label for="is_active" class="form-check-label">
                Buku aktif dan tampil di katalog
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

    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
        Batal
    </a>
</div>
