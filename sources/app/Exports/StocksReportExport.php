<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StocksReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(
        private readonly ?string $search = null,
        private readonly ?string $stockStatus = null,
    ) {
    }

    public function collection(): Collection
    {
        return Book::query()
            ->with(['category', 'supplier'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('title', 'like', "%{$this->search}%")
                        ->orWhere('author', 'like', "%{$this->search}%")
                        ->orWhere('isbn', 'like', "%{$this->search}%");
                });
            })
            ->when($this->stockStatus === 'empty', function ($query) {
                $query->where('stock', 0);
            })
            ->when($this->stockStatus === 'low', function ($query) {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            })
            ->when($this->stockStatus === 'safe', function ($query) {
                $query->where('stock', '>', 5);
            })
            ->orderBy('stock')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Judul Buku',
            'Penulis',
            'ISBN',
            'Kategori',
            'Supplier',
            'Harga',
            'Stok',
            'Status Stok',
            'Status Buku',
        ];
    }

    public function map($book): array
    {
        $stockLabel = 'Aman';

        if ($book->stock <= 0) {
            $stockLabel = 'Habis';
        } elseif ($book->stock <= 5) {
            $stockLabel = 'Menipis';
        }

        return [
            $book->title,
            $book->author ?: '-',
            $book->isbn ?: '-',
            $book->category?->name ?? '-',
            $book->supplier?->name ?? '-',
            (float) $book->price,
            $book->stock,
            $stockLabel,
            $book->is_active ? 'Aktif' : 'Nonaktif',
        ];
    }
}
