@extends('layouts.admin')

@section('title', 'Detail Pesanan - BookStore')
@section('page_title', 'Detail Pesanan')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pesanan</h1>
            <p class="text-secondary mb-0">
                Invoice: <span class="fw-semibold">{{ $order->invoice_number }}</span>
            </p>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            Kembali ke Pesanan
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card content-card mb-4">
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
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $item->book_title }}</div>
                                            @if ($item->book)
                                                <div class="small text-secondary">
                                                    {{ $item->book->category?->name ?? '-' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $item->formatted_book_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-semibold">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal Buku</th>
                                    <th class="text-end">{{ $order->formatted_subtotal_price }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Ongkos Kirim</th>
                                    <th class="text-end">{{ $order->formatted_shipping_cost }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th class="text-end text-primary">{{ $order->formatted_total_price }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Informasi Customer & Alamat</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama Customer</dt>
                        <dd class="col-sm-8">{{ $order->customer_name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $order->customer_email }}</dd>

                        <dt class="col-sm-4">No. Telepon</dt>
                        <dd class="col-sm-8">{{ $order->customer_phone ?: '-' }}</dd>

                        <dt class="col-sm-4">Wilayah</dt>
                        <dd class="col-sm-8">{{ $order->shipping_area }}</dd>

                        <dt class="col-sm-4">Alamat Pengiriman</dt>
                        <dd class="col-sm-8" style="white-space: pre-line;">{{ $order->shipping_address }}</dd>

                        <dt class="col-sm-4">Catatan Customer</dt>
                        <dd class="col-sm-8" style="white-space: pre-line;">{{ $order->notes ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-2 align-items-md-start mb-3">
                        <div>
                            <h2 class="h5 fw-bold mb-1">Ongkir Manual & Resi</h2>
                            <p class="text-secondary small mb-0">
                                Simpan ongkir terlebih dahulu. Setelah pembayaran diverifikasi, admin dapat menandai pesanan dikirim.
                            </p>
                        </div>

                        @if ($order->tracking_number)
                            <span class="badge text-bg-dark">
                                Resi: {{ $order->tracking_number }}
                            </span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.orders.update-shipping', $order) }}">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="shipping_courier" class="form-label">Kurir</label>
                                <input id="shipping_courier" type="text" name="shipping_courier" class="form-control @error('shipping_courier') is-invalid @enderror" value="{{ old('shipping_courier', $order->shipping_courier) }}" maxlength="100" placeholder="Contoh: JNE, J&T, SiCepat">
                                @error('shipping_courier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_service" class="form-label">Layanan</label>
                                <input id="shipping_service" type="text" name="shipping_service" class="form-control @error('shipping_service') is-invalid @enderror" value="{{ old('shipping_service', $order->shipping_service) }}" maxlength="100" placeholder="Contoh: REG, YES, Cargo">
                                @error('shipping_service')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipping_cost" class="form-label">Ongkos Kirim</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input id="shipping_cost" type="number" name="shipping_cost" class="form-control @error('shipping_cost') is-invalid @enderror" value="{{ old('shipping_cost', (int) $order->shipping_cost) }}" required min="0" step="100">
                                    @error('shipping_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-text">Isi 0 jika gratis ongkir.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="tracking_number" class="form-label">Nomor Resi</label>
                                <input id="tracking_number" type="text" name="tracking_number" class="form-control @error('tracking_number') is-invalid @enderror" value="{{ old('tracking_number', $order->tracking_number) }}" maxlength="100" placeholder="Wajib jika tandai dikirim">
                                @error('tracking_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label for="shipped_at" class="form-label">Tanggal Dikirim</label>
                                <input id="shipped_at" type="datetime-local" name="shipped_at" class="form-control @error('shipped_at') is-invalid @enderror" value="{{ old('shipped_at', $order->shipped_at?->format('Y-m-d\\TH:i')) }}">
                                @error('shipped_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                Simpan Ongkir & Resi
                            </button>

                            <button
                                type="submit"
                                name="mark_shipped"
                                value="1"
                                class="btn btn-outline-dark"
                                @disabled($order->payment?->status !== \App\Models\Payment::STATUS_VERIFIED)
                            >
                                Simpan & Tandai Dikirim
                            </button>
                        </div>

                        @if ($order->payment?->status !== \App\Models\Payment::STATUS_VERIFIED)
                            <div class="form-text text-warning mt-2">
                                Tombol tandai dikirim aktif setelah pembayaran diverifikasi.
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card content-card">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Timeline Pengiriman</h2>

                    <div class="vstack gap-3">
                        @foreach ($order->shipment_timeline as $timeline)
                            <div class="d-flex gap-3">
                                <div>
                                    <span class="badge rounded-pill {{ $timeline['active'] ? 'text-bg-success' : 'text-bg-light border text-secondary' }}">
                                        {{ $loop->iteration }}
                                    </span>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $timeline['label'] }}</div>
                                    <div class="small text-secondary">{{ $timeline['description'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Status Order</h2>

                    <div class="mb-3">
                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                    </div>

                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="status" class="form-label">Ubah Status Manual</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                @foreach ($statuses as $statusKey => $statusLabel)
                                    <option value="{{ $statusKey }}" @selected(old('status', $order->status) === $statusKey)>
                                        {{ $statusLabel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>

                    <hr>

                    <div class="vstack gap-2">
                        <form method="POST" action="{{ route('admin.orders.mark-processing', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-secondary w-100" @disabled($order->payment?->status !== \App\Models\Payment::STATUS_VERIFIED)>
                                Tandai Diproses
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.orders.mark-completed', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-success w-100" @disabled(! in_array($order->status, [\App\Models\Order::STATUS_SHIPPED, \App\Models\Order::STATUS_PROCESSING, \App\Models\Order::STATUS_PAID], true))>
                                Tandai Selesai
                            </button>
                        </form>
                    </div>

                    <div class="small text-secondary mt-3">
                        Alur disarankan: Menunggu Ongkir → Menunggu Pembayaran → Sudah Dibayar → Diproses → Dikirim → Selesai.
                    </div>
                </div>
            </div>

            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Ringkasan</h2>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Invoice</span>
                        <span class="fw-semibold">{{ $order->invoice_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Tanggal</span>
                        <span class="fw-semibold">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Total Item</span>
                        <span class="fw-semibold">{{ $order->items->sum('quantity') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Subtotal</span>
                        <span class="fw-semibold">{{ $order->formatted_subtotal_price }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Ongkir</span>
                        <span class="fw-semibold">{{ $order->formatted_shipping_cost }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Kurir</span>
                        <span class="fw-semibold text-end">{{ $order->shipping_courier_label }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Resi</span>
                        <span class="fw-semibold text-end">{{ $order->tracking_number ?: '-' }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Total Harga</span>
                        <span class="fw-bold text-primary">{{ $order->formatted_total_price }}</span>
                    </div>
                </div>
            </div>

            @if ($order->payment)
                <div class="card content-card">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Pembayaran</h2>

                        <div class="mb-3">
                            <span class="badge {{ $order->payment->status_badge_class }}">{{ $order->payment->status_label }}</span>
                        </div>

                        <div class="small text-secondary mb-1">Nama Pengirim</div>
                        <div class="fw-semibold mb-3">{{ $order->payment->sender_name }}</div>

                        <div class="small text-secondary mb-1">Nominal Transfer</div>
                        <div class="fw-semibold text-primary mb-3">{{ $order->payment->formatted_transfer_amount }}</div>

                        <a href="{{ route('admin.payments.show', $order->payment) }}" class="btn btn-outline-primary w-100">
                            Lihat Pembayaran
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <div class="fw-semibold mb-1">Belum ada pembayaran</div>
                    <div class="small">Customer belum upload bukti transfer untuk pesanan ini.</div>
                </div>
            @endif
        </div>
    </div>
@endsection
