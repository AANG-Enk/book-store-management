<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Exports\CustomersReportExport;
use App\Exports\PaymentsReportExport;
use App\Exports\SalesReportExport;
use App\Exports\StocksReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index(): View
    {
        $totalSales = Order::query()
            ->whereIn('status', [
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_COMPLETED,
            ])
            ->sum('total_price');

        $totalSubtotalSales = Order::query()
            ->whereIn('status', [
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_COMPLETED,
            ])
            ->sum('subtotal_price');

        $totalShippingCost = Order::query()
            ->whereIn('status', [
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_COMPLETED,
            ])
            ->sum('shipping_cost');

        $totalOrders = Order::query()->count();

        $pendingPayments = Payment::query()
            ->where('status', Payment::STATUS_PENDING)
            ->count();

        $lowStockBooks = Book::query()
            ->where('stock', '<=', 5)
            ->count();

        $totalCustomers = User::query()
            ->where('role', 'customer')
            ->count();

        return view('admin.reports.index', compact(
            'totalSales',
            'totalSubtotalSales',
            'totalShippingCost',
            'totalOrders',
            'pendingPayments',
            'lowStockBooks',
            'totalCustomers'
        ));
    }

    public function sales(Request $request): View
    {
        $startDate = $request->string('start_date')->toString();
        $endDate = $request->string('end_date')->toString();
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->with(['user', 'items'])
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summaryQuery = Order::query()
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            });

        $totalOrders = (clone $summaryQuery)->count();
        $totalSubtotalSales = (clone $summaryQuery)->sum('subtotal_price');
        $totalShippingCost = (clone $summaryQuery)->sum('shipping_cost');
        $totalSales = (clone $summaryQuery)->sum('total_price');

        $statuses = $this->orderStatuses();

        return view('admin.reports.sales', compact(
            'orders',
            'startDate',
            'endDate',
            'status',
            'statuses',
            'totalOrders',
            'totalSubtotalSales',
            'totalShippingCost',
            'totalSales'
        ));
    }

    public function payments(Request $request): View
    {
        $startDate = $request->string('start_date')->toString();
        $endDate = $request->string('end_date')->toString();
        $status = $request->string('status')->toString();

        $payments = Payment::query()
            ->with('order')
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summaryQuery = Payment::query()
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            });

        $totalPayments = (clone $summaryQuery)->count();
        $totalTransfer = (clone $summaryQuery)->sum('transfer_amount');

        $paymentStatuses = [
            Payment::STATUS_PENDING => 'Menunggu Verifikasi',
            Payment::STATUS_VERIFIED => 'Diverifikasi',
            Payment::STATUS_REJECTED => 'Ditolak',
        ];

        return view('admin.reports.payments', compact(
            'payments',
            'startDate',
            'endDate',
            'status',
            'paymentStatuses',
            'totalPayments',
            'totalTransfer'
        ));
    }

    public function stocks(Request $request): View
    {
        $search = $request->string('search')->toString();
        $stockStatus = $request->string('stock_status')->toString();

        $books = Book::query()
            ->with(['category', 'supplier'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($stockStatus === 'empty', function ($query) {
                $query->where('stock', 0);
            })
            ->when($stockStatus === 'low', function ($query) {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            })
            ->when($stockStatus === 'safe', function ($query) {
                $query->where('stock', '>', 5);
            })
            ->orderBy('stock')
            ->paginate(15)
            ->withQueryString();

        $totalBooks = Book::query()->count();
        $emptyStock = Book::query()->where('stock', 0)->count();
        $lowStock = Book::query()->where('stock', '>', 0)->where('stock', '<=', 5)->count();

        return view('admin.reports.stocks', compact(
            'books',
            'search',
            'stockStatus',
            'totalBooks',
            'emptyStock',
            'lowStock'
        ));
    }

    public function customers(Request $request): View
    {
        $search = $request->string('search')->toString();

        $customers = User::query()
            ->where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalCustomers = User::query()
            ->where('role', 'customer')
            ->count();

        return view('admin.reports.customers', compact(
            'customers',
            'search',
            'totalCustomers'
        ));
    }

    public function exportSales(Request $request): BinaryFileResponse
    {
        $startDate = $request->string('start_date')->toString() ?: null;
        $endDate = $request->string('end_date')->toString() ?: null;
        $status = $request->string('status')->toString() ?: null;

        $fileName = 'laporan-penjualan-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new SalesReportExport($startDate, $endDate, $status),
            $fileName
        );
    }

    public function exportPayments(Request $request): BinaryFileResponse
    {
        $startDate = $request->string('start_date')->toString() ?: null;
        $endDate = $request->string('end_date')->toString() ?: null;
        $status = $request->string('status')->toString() ?: null;

        $fileName = 'laporan-pembayaran-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new PaymentsReportExport($startDate, $endDate, $status),
            $fileName
        );
    }

    public function exportStocks(Request $request): BinaryFileResponse
    {
        $search = $request->string('search')->toString() ?: null;
        $stockStatus = $request->string('stock_status')->toString() ?: null;

        $fileName = 'laporan-stok-buku-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new StocksReportExport($search, $stockStatus),
            $fileName
        );
    }

    public function exportCustomers(Request $request): BinaryFileResponse
    {
        $search = $request->string('search')->toString() ?: null;

        $fileName = 'laporan-customer-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new CustomersReportExport($search),
            $fileName
        );
    }

    public function exportSalesPdf(Request $request): Response
    {
        $startDate = $request->string('start_date')->toString() ?: null;
        $endDate = $request->string('end_date')->toString() ?: null;
        $status = $request->string('status')->toString() ?: null;

        $orders = Order::query()
            ->with(['items'])
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        $totalOrders = $orders->count();
        $totalSubtotalSales = $orders->sum('subtotal_price');
        $totalShippingCost = $orders->sum('shipping_cost');
        $totalSales = $orders->sum('total_price');

        $pdf = Pdf::loadView('admin.reports.pdf.sales', compact(
            'orders',
            'startDate',
            'endDate',
            'status',
            'totalOrders',
            'totalSubtotalSales',
            'totalShippingCost',
            'totalSales'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-penjualan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportPaymentsPdf(Request $request): Response
    {
        $startDate = $request->string('start_date')->toString() ?: null;
        $endDate = $request->string('end_date')->toString() ?: null;
        $status = $request->string('status')->toString() ?: null;

        $payments = Payment::query()
            ->with('order')
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        $totalPayments = $payments->count();
        $totalTransfer = $payments->sum('transfer_amount');

        $pdf = Pdf::loadView('admin.reports.pdf.payments', compact(
            'payments',
            'startDate',
            'endDate',
            'status',
            'totalPayments',
            'totalTransfer'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pembayaran-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportStocksPdf(Request $request): Response
    {
        $search = $request->string('search')->toString() ?: null;
        $stockStatus = $request->string('stock_status')->toString() ?: null;

        $books = Book::query()
            ->with(['category', 'supplier'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($stockStatus === 'empty', function ($query) {
                $query->where('stock', 0);
            })
            ->when($stockStatus === 'low', function ($query) {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            })
            ->when($stockStatus === 'safe', function ($query) {
                $query->where('stock', '>', 5);
            })
            ->orderBy('stock')
            ->get();

        $totalBooks = $books->count();
        $emptyStock = $books->where('stock', 0)->count();
        $lowStock = $books->where('stock', '>', 0)->where('stock', '<=', 5)->count();

        $pdf = Pdf::loadView('admin.reports.pdf.stocks', compact(
            'books',
            'search',
            'stockStatus',
            'totalBooks',
            'emptyStock',
            'lowStock'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-stok-buku-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportCustomersPdf(Request $request): Response
    {
        $search = $request->string('search')->toString() ?: null;

        $customers = User::query()
            ->where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $totalCustomers = $customers->count();

        $pdf = Pdf::loadView('admin.reports.pdf.customers', compact(
            'customers',
            'search',
            'totalCustomers'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-customer-' . now()->format('Ymd-His') . '.pdf');
    }

    private function orderStatuses(): array
    {
        return [
            Order::STATUS_WAITING_SHIPPING => 'Menunggu Ongkir',
            Order::STATUS_WAITING_PAYMENT => 'Menunggu Pembayaran',
            Order::STATUS_PAID => 'Sudah Dibayar',
            Order::STATUS_PROCESSING => 'Diproses',
            Order::STATUS_COMPLETED => 'Selesai',
            Order::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }
}
