@extends('layouts.admin')

@section('title', 'Laporan Customer - BookStore')
@section('page_title', 'Laporan Customer')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 align-items-md-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Laporan Customer</h1>
            <p class="text-secondary mb-0">
                Data customer, jumlah order, dan total belanja.
            </p>
        </div>

        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
            Kembali ke Laporan
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.customers') }}" class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label for="search" class="form-label">Cari Customer</label>
                    <input
                        id="search"
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search }}"
                        placeholder="Nama atau email customer"
                    >
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary flex-fill">
                            <i class="bi bi-search me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('admin.reports.customers') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <p class="text-secondary mb-1">Total Customer</p>
            <h2 class="h4 fw-bold mb-0">{{ $totalCustomers }}</h2>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if ($customers->isEmpty())
                <div class="text-center py-5">
                    <div class="display-5 text-secondary mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h2 class="h5 fw-bold">Data customer tidak ditemukan</h2>
                    <p class="text-secondary mb-0">
                        Coba ubah kata kunci pencarian.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Bergabung</th>
                                <th>Jumlah Order</th>
                                <th>Total Belanja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td class="fw-semibold">{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge text-bg-light border">
                                            {{ $customer->orders_count }} order
                                        </span>
                                    </td>
                                    <td class="fw-semibold">
                                        Rp {{ number_format((float) ($customer->orders_sum_total_price ?? 0), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
