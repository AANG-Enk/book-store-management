@extends('layouts.admin')

@section('title', 'Detail Pembayaran - Toko Buku NusaCendana')
@section('page_title', 'Detail Pembayaran')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pembayaran</h1>
            <p class="text-secondary mb-0">
                Invoice: <span class="fw-semibold text-primary">{{ $payment->order->invoice_number }}</span>
            </p>
        </div>

        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            @if ($payment->is_midtrans)
                <div class="card content-card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h2 class="h5 fw-bold mb-0">Transaksi Midtrans Gateway</h2>
                            <span class="badge bg-primary-subtle text-primary">
                                <i class="bi bi-shield-check me-1"></i> Midtrans Snap
                            </span>
                        </div>

                        <div class="p-3 bg-light rounded mb-3">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted">ID Transaksi Midtrans</dt>
                                <dd class="col-sm-7 fw-semibold font-monospace">{{ $payment->transaction_id ?: '-' }}</dd>

                                <dt class="col-sm-5 text-muted">Tipe Pembayaran</dt>
                                <dd class="col-sm-7 fw-semibold">{{ strtoupper($payment->payment_type ?: 'Midtrans Gateway') }}</dd>

                                <dt class="col-sm-5 text-muted">Status Transaksi</dt>
                                <dd class="col-sm-7">
                                    <span class="badge {{ $payment->status_badge_class }}">
                                        {{ $payment->transaction_status ? ucfirst($payment->transaction_status) : $payment->status_label }}
                                    </span>
                                </dd>

                                <dt class="col-sm-5 text-muted">Waktu Transaksi</dt>
                                <dd class="col-sm-7">{{ $payment->transaction_time?->format('d M Y H:i:s') ?? $payment->created_at->format('d M Y H:i:s') }}</dd>

                                <dt class="col-sm-5 text-muted">Total Bayar</dt>
                                <dd class="col-sm-7 fw-bold text-primary">{{ $payment->formatted_transfer_amount }}</dd>
                            </dl>
                        </div>

                        @if ($payment->payment_payload)
                            <div class="accordion" id="accordionPayload">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed px-0 bg-transparent text-secondary small" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePayload">
                                            <i class="bi bi-code-square me-2"></i> Lihat Data Payload Webhook Midtrans
                                        </button>
                                    </h2>
                                    <div id="collapsePayload" class="accordion-collapse collapse">
                                        <div class="accordion-body p-2 bg-dark rounded text-light small font-monospace" style="max-height: 200px; overflow-y: auto;">
                                            <pre class="mb-0 text-light" style="font-size: 0.75rem;">{{ json_encode($payment->payment_payload, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif ($payment->proof_image)
                <div class="card content-card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Bukti Transfer Manual</h2>

                        <a href="{{ $payment->proof_url }}" target="_blank">
                            <img
                                src="{{ $payment->proof_url }}"
                                alt="Bukti pembayaran"
                                class="payment-proof-admin border rounded"
                            >
                        </a>
                    </div>
                </div>
            @endif

            <div class="card content-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Item Pesanan</h2>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Buku</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->order->items as $item)
                                    <tr>
                                        <td>{{ $item->book_title }}</td>
                                        <td>{{ $item->formatted_book_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end text-muted">Subtotal Buku</th>
                                    <th class="text-end">{{ $payment->order->formatted_subtotal_price }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end text-muted">Ongkir ({{ $payment->order->shipping_courier_label }})</th>
                                    <th class="text-end">{{ $payment->order->formatted_shipping_cost }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end fw-bold">Total Tagihan</th>
                                    <th class="text-end text-primary fw-bold">
                                        {{ $payment->order->formatted_total_price }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card content-card mb-4 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Ringkasan Pembayaran</h2>

                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted">Status</dt>
                        <dd class="col-sm-7">
                            <span class="badge {{ $payment->status_badge_class }}">
                                {{ $payment->status_label }}
                            </span>
                        </dd>

                        <dt class="col-sm-5 text-muted">Metode</dt>
                        <dd class="col-sm-7">{{ $payment->payment_method_label }}</dd>

                        <dt class="col-sm-5 text-muted">Customer</dt>
                        <dd class="col-sm-7">{{ $payment->order->customer_name }}</dd>

                        <dt class="col-sm-5 text-muted">Nominal</dt>
                        <dd class="col-sm-7 fw-bold text-primary">{{ $payment->formatted_transfer_amount }}</dd>

                        <dt class="col-sm-5 text-muted">Dibuat</dt>
                        <dd class="col-sm-7">{{ $payment->created_at->format('d M Y H:i') }}</dd>

                        <dt class="col-sm-5 text-muted">Diverifikasi</dt>
                        <dd class="col-sm-7">
                            {{ $payment->verified_at ? $payment->verified_at->format('d M Y H:i') : '-' }}
                        </dd>

                        @if ($payment->admin_note)
                            <dt class="col-sm-5 text-muted">Catatan</dt>
                            <dd class="col-sm-7" style="white-space: pre-line;">{{ $payment->admin_note }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            @if ($payment->status !== \App\Models\Payment::STATUS_VERIFIED)
                <div class="card content-card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Tindakan Admin</h2>

                        <form
                            method="POST"
                            action="{{ route('admin.payments.verify', $payment) }}"
                            onsubmit="return confirm('Tandai pembayaran ini telah diverifikasi?')"
                            class="mb-3"
                        >
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i>
                                Verifikasi Manual (Set Lunas)
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('admin.payments.reject', $payment) }}"
                            onsubmit="return confirm('Tolak atau batalkan pembayaran ini?')"
                        >
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="admin_note" class="form-label">Alasan Penolakan / Pembatalan</label>
                                <textarea
                                    id="admin_note"
                                    name="admin_note"
                                    rows="3"
                                    class="form-control @error('admin_note') is-invalid @enderror"
                                    required
                                    maxlength="1000"
                                    placeholder="Contoh: Transaksi kedaluwarsa / dibatalkan"
                                >{{ old('admin_note') }}</textarea>

                                @error('admin_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-1"></i>
                                Tolak Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card content-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Data Pemesan</h2>

                    <div class="fw-semibold">{{ $payment->order->customer_name }}</div>
                    <div class="text-secondary small">{{ $payment->order->customer_email }}</div>
                    <div class="text-secondary small">{{ $payment->order->customer_phone ?: '-' }}</div>
                    <hr>
                    <div class="small text-muted">
                        {{ $payment->order->shipping_address }}, {{ $payment->order->shipping_area }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
