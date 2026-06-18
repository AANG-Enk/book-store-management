@extends('layouts.admin')

@section('title', 'Laporan Pembayaran - BookStore')
@section('page_title', 'Laporan Pembayaran')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Laporan Pembayaran</h1>
            <p class="text-secondary mb-0">
                Data pembayaran manual dan status verifikasi.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a
                href="{{ route('admin.reports.payments.export', request()->query()) }}"
                class="btn btn-success"
            >
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel
            </a>

            <a
                href="{{ route('admin.reports.payments.pdf', request()->query()) }}"
                class="btn btn-danger"
                target="_blank"
            >
                <i class="bi bi-file-earmark-pdf me-1"></i>
                Export PDF
            </a>

            <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                <i class="bi bi-printer me-1"></i>
                Print
            </button>

            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                Kembali ke Laporan
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.payments') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input
                        id="start_date"
                        type="date"
                        name="start_date"
                        class="form-control"
                        value="{{ $startDate }}"
                    >
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input
                        id="end_date"
                        type="date"
                        name="end_date"
                        class="form-control"
                        value="{{ $endDate }}"
                    >
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status Pembayaran</label>
                    <select id="status" name="status" class="form-select">
                        <option value="" @selected($status === '')>Semua Status</option>
                        @foreach ($paymentStatuses as $statusKey => $statusLabel)
                            <option value="{{ $statusKey }}" @selected($status === $statusKey)>
                                {{ $statusLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.reports.payments') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Data Pembayaran</p>
                    <h2 class="h4 fw-bold mb-0">{{ $totalPayments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-secondary mb-1">Total Nominal Transfer</p>
                    <h2 class="h4 fw-bold mb-0">
                        Rp {{ number_format($totalTransfer, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($payments->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h2 class="h5 fw-bold">Data pembayaran tidak ditemukan</h2>
                    <p class="text-secondary mb-0">
                        Coba ubah filter tanggal atau status pembayaran.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Tanggal Upload</th>
                                <th>Pengirim</th>
                                <th>Bank</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th class="text-end">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $payment->order?->invoice_number ?? '-' }}
                                    </td>
                                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ $payment->sender_name }}</td>
                                    <td>{{ $payment->bank_name ?: '-' }}</td>
                                    <td class="fw-semibold">{{ $payment->formatted_transfer_amount }}</td>
                                    <td>
                                        <span class="badge {{ $payment->status_badge_class }}">
                                            {{ $payment->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a
                                            href="{{ route('admin.payments.show', $payment) }}"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
