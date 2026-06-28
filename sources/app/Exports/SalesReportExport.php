<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $startDate = null,
        private readonly ?string $endDate = null,
        private readonly ?string $status = null,
    ) {
    }

    public function collection(): Collection
    {
        return Order::query()
            ->with(['items'])
            ->when($this->startDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Tanggal',
            'Nama Customer',
            'Email Customer',
            'Total Item',
            'Kurir',
            'Layanan',
            'Resi',
            'Subtotal Produk',
            'Ongkir',
            'Grand Total',
            'Status',
        ];
    }

    public function map($order): array
    {
        return [
            $order->invoice_number,
            $order->created_at->format('d/m/Y H:i'),
            $order->customer_name,
            $order->customer_email,
            $order->items->sum('quantity'),
            $order->shipping_courier ?: '-',
            $order->shipping_service ?: '-',
            $order->tracking_number ?: '-',
            (float) $order->subtotal_price,
            (float) $order->shipping_cost,
            (float) $order->total_price,
            $order->status_label,
        ];
    }
}
