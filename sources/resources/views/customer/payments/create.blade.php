@extends('layouts.customer')

@section('title', 'Pembayaran Pesanan ' . $order->invoice_number . ' - Toko Buku NusaCendana')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Pembayaran Pesanan</h1>
        <p class="text-secondary mb-0">
            Selesaikan pembayaran pesanan <span class="fw-semibold text-primary">#{{ $order->invoice_number }}</span> melalui Midtrans Payment Gateway.
        </p>
    </div>

    <div class="row g-4">
        <!-- Rincian Pesanan -->
        <div class="col-lg-7">
            <div class="card content-card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Rincian Pembelian</h2>
                        <span class="badge bg-primary-subtle text-primary">
                            {{ $order->invoice_number }}
                        </span>
                    </div>

                    <div class="table-responsive mb-3">
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
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $item->book_title }}</div>
                                            @if ($item->book)
                                                <div class="small text-muted">{{ $item->book->category?->name ?? '-' }}</div>
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
                                    <th colspan="3" class="text-end text-muted">Subtotal Buku</th>
                                    <th class="text-end">{{ $order->formatted_subtotal_price }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end text-muted">
                                        Ongkir ({{ $order->shipping_courier_label }})
                                    </th>
                                    <th class="text-end text-success">{{ $order->formatted_shipping_cost }}</th>
                                </tr>
                                <tr class="table-active">
                                    <th colspan="3" class="text-end h6 mb-0 fw-bold">Total Pembayaran</th>
                                    <th class="text-end h5 mb-0 fw-bold text-primary">{{ $order->formatted_total_price }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="p-3 bg-light rounded">
                        <div class="fw-bold mb-1"><i class="bi bi-geo-alt me-1 text-primary"></i> Alamat Pengiriman</div>
                        <div class="small text-secondary">{{ $order->customer_name }} ({{ $order->customer_phone ?: '-' }})</div>
                        <div class="small text-secondary">{{ $order->shipping_address }}, {{ $order->shipping_area }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Gateway Box -->
        <div class="col-lg-5">
            <div class="card content-card border-0 shadow-sm sticky-lg-top" style="top: 2rem;">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <div class="badge bg-success-subtle text-success p-2 px-3 rounded-pill fw-semibold mb-2">
                            <i class="bi bi-shield-lock-fill me-1"></i> Midtrans Secure Payment
                        </div>
                        <h2 class="h5 fw-bold mb-1">Total Tagihan</h2>
                        <div class="display-6 fw-bold text-primary my-2">
                            {{ $order->formatted_total_price }}
                        </div>
                        <p class="text-muted small">
                            Pilih metode pembayaran favorit Anda melalui Midtrans Snap.
                        </p>
                    </div>

                    <!-- Payment Channels Badges -->
                    <div class="p-3 border rounded bg-light-subtle mb-4 text-start">
                        <div class="small fw-bold text-muted mb-2 text-uppercase" style="font-size: 0.75rem;">Metode Pembayaran Tersedia:</div>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-white border text-dark p-2"><i class="bi bi-qr-code me-1 text-danger"></i> QRIS</span>
                            <span class="badge bg-white border text-dark p-2"><i class="bi bi-bank me-1 text-primary"></i> BCA VA</span>
                            <span class="badge bg-white border text-dark p-2"><i class="bi bi-bank me-1 text-warning"></i> BNI VA</span>
                            <span class="badge bg-white border text-dark p-2"><i class="bi bi-bank me-1 text-primary"></i> BRI VA</span>
                            <span class="badge bg-white border text-dark p-2"><i class="bi bi-bank me-1 text-info"></i> Mandiri</span>
                            <span class="badge bg-white border text-dark p-2"><i class="bi bi-wallet2 me-1 text-success"></i> GoPay / E-Wallet</span>
                        </div>
                    </div>

                    <!-- Action Button: Pay via Midtrans Snap -->
                    <button id="pay-button" type="button" class="btn btn-primary btn-lg w-100 shadow-sm mb-2 fw-bold">
                        <i class="bi bi-credit-card-2-front me-2"></i> Bayar Sekarang
                    </button>

                    <div class="small text-muted mt-2">
                        Transaksi aman & otomatis terverifikasi secara real-time.
                    </div>

                    @if (! $isConfigured)
                        <div class="alert alert-warning text-start small mt-4">
                            <div class="fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> Mode Simulasi Sandbox (Kunci API Belum Diisi)</div>
                            <div>
                                Anda dapat mengklik tombol di bawah untuk menyimulasikan notifikasi sukses pembayaran Midtrans:
                            </div>
                            <form method="POST" action="{{ route('customer.payments.simulate-success', $order) }}" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                    <i class="bi bi-check-circle me-1"></i> Simulasi Pembayaran Sukses (Instant Paid)
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('customer.orders.show', $order) }}" class="btn btn-link text-decoration-none text-muted small">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if ($clientKey)
        <script src="{{ $snapScriptUrl }}" data-client-key="{{ $clientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-sample"></script>
    @endif

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            const payButton = document.getElementById('pay-button');
            const snapToken = "{{ $snapToken }}";
            const orderShowUrl = "{{ route('customer.orders.show', $order) }}";
            const isConfigured = {{ $isConfigured ? 'true' : 'false' }};

            payButton.addEventListener('click', function () {
                if (window.snap && snapToken && isConfigured) {
                    window.snap.pay(snapToken, {
                        onSuccess: function (result) {
                            console.log('Payment success:', result);
                            window.location.href = "{{ route('customer.payments.finish', $order) }}?status=success";
                        },
                        onPending: function (result) {
                            console.log('Payment pending:', result);
                            window.location.href = "{{ route('customer.payments.finish', $order) }}?status=pending";
                        },
                        onError: function (result) {
                            console.error('Payment error:', result);
                            alert('Pembayaran gagal atau dibatalkan. Silakan coba kembali.');
                        },
                        onClose: function () {
                            console.log('Customer closed the popup without finishing the payment');
                        }
                    });
                } else {
                    // Fallback / Demo info
                    if (!isConfigured) {
                        alert('API Key Midtrans belum diset di .env. Silakan gunakan tombol "Simulasi Pembayaran Sukses" di bawah untuk menguji alur sistem.');
                    } else {
                        alert('Gagal memuat sistem pembayaran Midtrans. Silakan muat ulang halaman.');
                    }
                }
            });
        });
    </script>
@endpush
