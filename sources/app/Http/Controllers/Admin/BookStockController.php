<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookStockController extends Controller
{
    public function edit(Book $book): View
    {
        $book->load(['category', 'supplier']);

        return view('admin.books.stock', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $book->update([
            'stock' => $validated['stock'],
        ]);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Stok buku berhasil diperbarui.');
    }
}
