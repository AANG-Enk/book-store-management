<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = CartItem::query()
            ->with(['book.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $cartTotal = $cartItems->sum(fn (CartItem $item) => $item->subtotal);

        return view('customer.cart.index', compact('cartItems', 'cartTotal'));
    }

    public function store(Request $request, Book $book): RedirectResponse
    {
        abort_if(! auth()->user()->isCustomer(), 403);
        abort_if(! $book->is_active, 404);
        abort_if(! $book->category?->is_active, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($book->stock <= 0) {
            return back()->with('error', 'Buku tidak bisa ditambahkan karena stok habis.');
        }

        $quantity = (int) ($validated['quantity'] ?? 1);

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
        ]);

        $newQuantity = $cartItem->exists
            ? $cartItem->quantity + $quantity
            : $quantity;

        if ($newQuantity > $book->stock) {
            return back()->with('error', 'Jumlah buku di keranjang tidak boleh melebihi stok tersedia.');
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $validated['quantity'];

        if ($quantity > $cartItem->book->stock) {
            return back()->with('error', 'Jumlah tidak boleh melebihi stok tersedia.');
        }

        $cartItem->update([
            'quantity' => $quantity,
        ]);

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Jumlah item keranjang berhasil diperbarui.');
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($cartItem);

        $cartItem->delete();

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear(): RedirectResponse
    {
        CartItem::query()
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()
            ->route('customer.cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

    private function authorizeCartItem(CartItem $cartItem): void
    {
        abort_if($cartItem->user_id !== auth()->id(), 403);
        abort_if(! auth()->user()->isCustomer(), 403);
    }
}
