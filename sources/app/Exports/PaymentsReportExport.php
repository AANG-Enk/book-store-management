<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $startDate = null,
        private readonly ?string $endDate = null,
        private readonly ?string $status = null,
    ) {
    }

    public function collection(): Collection
    {
        return Payment::query()
            ->with('order')
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
            'Tanggal Upload',
            'Nama Customer',
            'Email Customer',
            'Nama Pengirim',
            'Bank / Metode',
            'Nominal Transfer',
            'Status Pembayaran',
            'Tanggal Verifikasi',
            'Catatan Admin',
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->order?->invoice_number ?? '-',
            $payment->created_at->format('d/m/Y H:i'),
            $payment->order?->customer_name ?? '-',
            $payment->order?->customer_email ?? '-',
            $payment->sender_name,
            $payment->bank_name ?: '-',
            (float) $payment->transfer_amount,
            $payment->status_label,
            $payment->verified_at ? $payment->verified_at->format('d/m/Y H:i') : '-',
            $payment->admin_note ?: '-',
        ];
    }
}
