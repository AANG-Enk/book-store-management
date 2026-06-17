<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Keranjang masih kosong. Tambahkan buku terlebih dahulu.');
        }

        $cartTotal = $cartItems->sum(fn (CartItem $item) => $item->subtotal);

        return view('customer.checkout.create', compact('cartItems', 'cartTotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('customer.cart.index')
                ->with('error', 'Keranjang masih kosong. Tambahkan buku terlebih dahulu.');
        }

        foreach ($cartItems as $cartItem) {
            if (! $cartItem->book->is_active || ! $cartItem->book->category?->is_active) {
                return redirect()
                    ->route('customer.cart.index')
                    ->with('error', 'Ada buku yang sudah tidak tersedia. Silakan periksa kembali keranjang.');
            }

            if ($cartItem->quantity > $cartItem->book->stock) {
                return redirect()
                    ->route('customer.cart.index')
                    ->with('error', 'Jumlah buku melebihi stok tersedia. Silakan update keranjang.');
            }
        }

        $order = DB::transaction(function () use ($validated, $cartItems) {
            $totalPrice = $cartItems->sum(fn (CartItem $item) => $item->subtotal);

            $order = Order::query()->create([
                'user_id' => auth()->id(),
                'invoice_number' => $this->generateInvoiceNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'],
                'total_price' => $totalPrice,
                'status' => Order::STATUS_WAITING_PAYMENT,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cartItems as $cartItem) {
                $book = Book::query()
                    ->whereKey($cartItem->book_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($cartItem->quantity > $book->stock) {
                    throw new \RuntimeException('Stok buku tidak mencukupi.');
                }

                $subtotal = (float) $book->price * $cartItem->quantity;

                $order->items()->create([
                    'book_id' => $book->id,
                    'book_title' => $book->title,
                    'book_price' => $book->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $subtotal,
                ]);

                $book->decrement('stock', $cartItem->quantity);
            }

            CartItem::query()
                ->where('user_id', auth()->id())
                ->delete();

            return $order;
        });

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Checkout berhasil. Silakan lanjutkan ke pembayaran manual.');
    }

    private function getCartItems()
    {
        return CartItem::query()
            ->with(['book.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');

        $latestOrder = Order::query()
            ->whereDate('created_at', now()->toDateString())
            ->latest('id')
            ->first();

        $sequence = $latestOrder
            ? ((int) substr($latestOrder->invoice_number, -4)) + 1
            : 1;

        return 'INV-' . $date . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
