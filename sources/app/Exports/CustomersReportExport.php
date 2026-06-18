<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $search = null,
    ) {
    }

    public function collection(): Collection
    {
        return User::query()
            ->where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total_price')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Customer',
            'Email',
            'Tanggal Bergabung',
            'Jumlah Order',
            'Total Belanja',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->email,
            $customer->created_at->format('d/m/Y H:i'),
            $customer->orders_count,
            (float) ($customer->orders_sum_total_price ?? 0),
        ];
    }
}
