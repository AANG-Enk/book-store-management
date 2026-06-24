@extends('layouts.customer')

@section('title', 'Checkout - BookStore')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Checkout</h1>
        <p class="text-secondary mb-0">
            Lengkapi data pengiriman. Ongkos kirim akan ditentukan manual oleh admin.
        </p>
    </div>

    <form method="POST" action="{{ route('customer.checkout.store') }}">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card content-card mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Data Customer</h2>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Nama Penerima</label>
                                <input
                                    id="customer_name"
                                    type="text"
                                    name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    value="{{ old('customer_name', auth()->user()->name) }}"
                                    required
                                    maxlength="150"
                                >

                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="customer_email" class="form-label">Email</label>
                                <input
                                    id="customer_email"
                                    type="email"
                                    name="customer_email"
                                    class="form-control @error('customer_email') is-invalid @enderror"
                                    value="{{ old('customer_email', auth()->user()->email) }}"
                                    required
                                    maxlength="150"
                                >

                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label">No. Telepon</label>
                                <input
                                    id="customer_phone"
                                    type="text"
                                    name="customer_phone"
                                    class="form-control @error('customer_phone') is-invalid @enderror"
                                    value="{{ old('customer_phone') }}"
                                    maxlength="30"
                                    placeholder="Contoh: 081234567890"
                                >

                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card content-card mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Alamat Pengiriman</h2>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="shipping_province" class="form-label">Provinsi</label>
                                <input
                                    id="shipping_province"
                                    type="text"
                                    name="shipping_province"
                                    class="form-control @error('shipping_province') is-invalid @enderror"
                                    value="{{ old('shipping_province') }}"
                                    required
                                    maxlength="100"
                                    placeholder="Contoh: Jawa Barat"
                                >

                                @error('shipping_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_city" class="form-label">Kota / Kabupaten</label>
                                <input
                                    id="shipping_city"
                                    type="text"
                                    name="shipping_city"
                                    class="form-control @error('shipping_city') is-invalid @enderror"
                                    value="{{ old('shipping_city') }}"
                                    required
                                    maxlength="100"
                                    placeholder="Contoh: Bandung"
                                >

                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_postal_code" class="form-label">Kode Pos</label>
                                <input
                                    id="shipping_postal_code"
                                    type="text"
                                    name="shipping_postal_code"
                                    class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                    value="{{ old('shipping_postal_code') }}"
                                    maxlength="20"
                                    placeholder="Opsional"
                                >

                                @error('shipping_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="shipping_address" class="form-label">Alamat Lengkap</label>
                                <textarea
                                    id="shipping_address"
                                    name="shipping_address"
                                    rows="4"
                                    class="form-control @error('shipping_address') is-invalid @enderror"
                                    required
                                    maxlength="1000"
                                    placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, patokan, dan detail lain"
                                >{{ old('shipping_address') }}</textarea>

                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label">Catatan Pengiriman</label>
                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="3"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    maxlength="1000"
                                    placeholder="Opsional, contoh: kirim setelah jam kerja"
                                >{{ old('notes') }}</textarea>

                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card content-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Item Pesanan</h2>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $cartItem->book->title }}</div>
                                                <div class="small text-secondary">
                                                    {{ $cartItem->book->category?->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td>{{ $cartItem->book->formatted_price }}</td>
                                            <td>{{ $cartItem->quantity }}</td>
                                            <td class="text-end fw-semibold">
                                                {{ $cartItem->formatted_subtotal }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary btn-sm">
                            Edit Keranjang
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card content-card sticky-lg-top cart-summary-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Ringkasan Checkout</h2>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Total Item</span>
                            <span class="fw-semibold">{{ $cartItems->sum('quantity') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Total Buku</span>
                            <span class="fw-semibold">{{ $cartItems->count() }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Subtotal Buku</span>
                            <span class="fw-semibold">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Ongkos Kirim</span>
                            <span class="fw-semibold text-warning">Ditentukan admin</span>
                        </div>

                        <div class="alert alert-info small">
                            Setelah pesanan dibuat, admin akan menentukan kurir dan ongkos kirim secara manual.
                            Customer dapat upload bukti pembayaran setelah ongkir dikonfirmasi.
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Buat Pesanan
                        </button>

                        <div class="small text-secondary mt-3">
                            Setelah pesanan dibuat, stok buku akan otomatis berkurang.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
