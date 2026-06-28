@extends('layouts.customer')

@section('title', 'Detail Pesanan ' . $order->invoice_number . ' - BookStore')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pesanan</h1>
            <p class="text-secondary mb-0">
                Invoice: <span class="fw-semibold">{{ $order->invoice_number }}</span>
            </p>
        </div>

        <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary">
            Kembali ke Riwayat
        </a>
    </div>

    @if ($order->status === \App\Models\Order::STATUS_WAITING_SHIPPING)
        <div class="alert alert-warning">
            <div class="fw-semibold mb-1">Pesanan menunggu ongkos kirim.</div>
            <div class="small">
                Admin akan menentukan kurir dan ongkir secara manual. Tombol upload pembayaran akan aktif setelah ongkir dikonfirmasi.
            </div>
        </div>
    @elseif ($order->status === \App\Models\Order::STATUS_SHIPPED)
        <div class="alert alert-success">
            <div class="fw-semibold mb-1">Pesanan sedang dikirim.</div>
            <div class="small">
                Kurir: {{ $order->shipping_courier_label }} · Resi: {{ $order->tracking_number ?: '-' }}
            </div>
        </div>
    @endif

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
                                                <div class="small text-secondary">{{ $item->book->category?->name ?? '-' }}</div>
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
                                    <th class="text-end">
                                        @if ($order->is_shipping_confirmed)
                                            {{ $order->formatted_shipping_cost }}
                                        @else
                                            <span class="text-warning">Menunggu admin</span>
                                        @endif
                                    </th>
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
                    <h2 class="h5 fw-bold mb-3">Timeline Pesanan</h2>

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

            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Informasi Pengiriman</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">{{ $order->customer_name }}</dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $order->customer_email }}</dd>

                        <dt class="col-sm-4">No. Telepon</dt>
                        <dd class="col-sm-8">{{ $order->customer_phone ?: '-' }}</dd>

                        <dt class="col-sm-4">Wilayah</dt>
                        <dd class="col-sm-8">{{ $order->shipping_area }}</dd>

                        <dt class="col-sm-4">Alamat</dt>
                        <dd class="col-sm-8" style="white-space: pre-line;">{{ $order->shipping_address }}</dd>

                        <dt class="col-sm-4">Catatan</dt>
                        <dd class="col-sm-8" style="white-space: pre-line;">{{ $order->notes ?: '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card content-card">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Kurir & Resi</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Kurir</dt>
                        <dd class="col-sm-8">{{ $order->shipping_courier_label }}</dd>

                        <dt class="col-sm-4">Nomor Resi</dt>
                        <dd class="col-sm-8">
                            @if ($order->tracking_number)
                                <span class="fw-semibold">{{ $order->tracking_number }}</span>
                            @else
                                -
                            @endif
                        </dd>

                        <dt class="col-sm-4">Tanggal Dikirim</dt>
                        <dd class="col-sm-8">{{ $order->shipped_at?->format('d M Y H:i') ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card content-card mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Status Pesanan</h2>

                    <div class="mb-3">
                        <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                    </div>

                    <div class="small text-secondary mb-2">Tanggal Pesanan</div>
                    <div class="fw-semibold mb-3">{{ $order->created_at->format('d M Y H:i') }}</div>

                    <div class="small text-secondary mb-2">Subtotal Buku</div>
                    <div class="fw-semibold mb-3">{{ $order->formatted_subtotal_price }}</div>

                    <div class="small text-secondary mb-2">Ongkos Kirim</div>
                    <div class="fw-semibold mb-3">
                        @if ($order->is_shipping_confirmed)
                            {{ $order->formatted_shipping_cost }}
                        @else
                            <span class="text-warning">Menunggu admin</span>
                        @endif
                    </div>

                    <div class="small text-secondary mb-2">Total Pembayaran</div>
                    <div class="h5 fw-bold text-primary mb-0">{{ $order->formatted_total_price }}</div>
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

                        @if ($order->payment->status === \App\Models\Payment::STATUS_REJECTED)
                            <div class="alert alert-danger">
                                <div class="fw-semibold">Pembayaran ditolak</div>
                                <div class="small">{{ $order->payment->admin_note }}</div>
                            </div>

                            <a href="{{ route('customer.payments.create', $order) }}" class="btn btn-primary w-100">
                                Upload Ulang Bukti Pembayaran
                            </a>
                        @elseif ($order->payment->status === \App\Models\Payment::STATUS_PENDING)
                            <div class="alert alert-warning small">
                                Bukti pembayaran sedang menunggu verifikasi admin.
                            </div>
                        @else
                            <div class="alert alert-success small">
                                Pembayaran sudah diverifikasi.
                            </div>
                        @endif
                    </div>
                </div>
            @elseif ($order->status === \App\Models\Order::STATUS_WAITING_SHIPPING)
                <div class="alert alert-warning">
                    <div class="fw-semibold mb-1">Belum bisa upload pembayaran</div>
                    <div class="small">Admin perlu menentukan ongkos kirim terlebih dahulu.</div>
                </div>
            @else
                <div class="alert alert-info">
                    <div class="fw-semibold mb-1">Pembayaran Manual</div>
                    <div class="small mb-3">Silakan upload bukti transfer sesuai total pembayaran.</div>

                    <a href="{{ route('customer.payments.create', $order) }}" class="btn btn-primary w-100">
                        Upload Bukti Pembayaran
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
