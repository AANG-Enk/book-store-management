@extends('layouts.customer')

@section('title', 'Keranjang Belanja - BookStore')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <span class="section-kicker mb-3"><i class="bi bi-cart"></i> Keranjang</span>
            <h1 class="h3 fw-bold mb-1">Keranjang Belanja</h1>
            <p class="text-secondary mb-0">Periksa buku yang ingin kamu beli sebelum checkout.</p>
        </div>

        <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-book me-1"></i>
            Lanjut Belanja
        </a>
    </div>

    @if ($cartItems->isEmpty())
        <div class="card content-card">
            <div class="card-body text-center py-5">
                <div class="empty-state-icon mb-3 mx-auto"><i class="bi bi-cart"></i></div>
                <h2 class="h5 fw-bold">Keranjang masih kosong</h2>
                <p class="text-secondary mb-4">Pilih buku dari katalog lalu tambahkan ke keranjang.</p>
                <a href="{{ route('books.index') }}" class="btn btn-primary">Lihat Katalog Buku</a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card content-card">
                    <div class="card-body p-0">
                        <div class="d-none d-md-block table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Buku</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th class="text-end pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex gap-3 align-items-center">
                                                    <div class="book-cover-thumb bg-light border d-flex align-items-center justify-content-center">
                                                        @if ($cartItem->book->cover_url)
                                                            <img src="{{ $cartItem->book->cover_url }}" alt="Cover {{ $cartItem->book->title }}">
                                                        @else
                                                            <i class="bi bi-book text-secondary"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold"><a href="{{ route('books.show', $cartItem->book) }}" class="text-dark">{{ $cartItem->book->title }}</a></div>
                                                        <div class="small text-secondary">{{ $cartItem->book->category?->name ?? '-' }} @if ($cartItem->book->author)&middot; {{ $cartItem->book->author }}@endif</div>
                                                        <div class="small {{ $cartItem->book->stock > 0 ? 'text-success' : 'text-danger' }}">Stok: {{ $cartItem->book->stock }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $cartItem->book->formatted_price }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('customer.cart.update', $cartItem) }}" class="d-flex gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $cartItem->quantity }}" min="1" max="{{ $cartItem->book->stock }}" required style="max-width: 90px;">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                                </form>
                                            </td>
                                            <td class="fw-semibold">{{ $cartItem->formatted_subtotal }}</td>
                                            <td class="text-end pe-4">
                                                <form method="POST" action="{{ route('customer.cart.destroy', $cartItem) }}" onsubmit="return confirm('Hapus buku ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-md-none p-3 mobile-card-list">
                            @foreach ($cartItems as $cartItem)
                                <div class="mobile-data-card">
                                    <div class="d-flex gap-3 align-items-start mb-3">
                                        <div class="book-cover-thumb bg-light border d-flex align-items-center justify-content-center">
                                            @if ($cartItem->book->cover_url)
                                                <img src="{{ $cartItem->book->cover_url }}" alt="Cover {{ $cartItem->book->title }}">
                                            @else
                                                <i class="bi bi-book text-secondary"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $cartItem->book->title }}</div>
                                            <div class="small text-secondary">{{ $cartItem->book->formatted_price }}</div>
                                            <div class="book-price mt-1">{{ $cartItem->formatted_subtotal }}</div>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('customer.cart.update', $cartItem) }}" class="d-flex gap-2 mb-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" class="form-control" value="{{ $cartItem->quantity }}" min="1" max="{{ $cartItem->book->stock }}" required>
                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                    </form>

                                    <form method="POST" action="{{ route('customer.cart.destroy', $cartItem) }}" onsubmit="return confirm('Hapus buku ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100">Hapus</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card content-card sticky-lg-top cart-summary-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Ringkasan Belanja</h2>
                        <div class="d-flex justify-content-between mb-2"><span class="text-secondary">Total Item</span><span class="fw-semibold">{{ $cartItems->sum('quantity') }}</span></div>
                        <div class="d-flex justify-content-between mb-3"><span class="text-secondary">Total Buku</span><span class="fw-semibold">{{ $cartItems->count() }}</span></div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-semibold">Total Harga</span>
                            <span class="h5 book-price mb-0">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('customer.checkout.create') }}" class="btn btn-primary w-100">Checkout</a>
                        <div class="small text-secondary mt-3">Pastikan jumlah buku sudah sesuai sebelum checkout.</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
