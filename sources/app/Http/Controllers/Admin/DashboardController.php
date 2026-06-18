<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ContactMessage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalBooks = Book::query()->count();
        $totalCategories = Category::query()->count();
        $totalCustomers = User::query()->where('role', 'customer')->count();
        $totalOrders = Order::query()->count();

        $lowStockBooks = Book::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->count();

        $emptyStockBooks = Book::query()
            ->where('stock', 0)
            ->count();

        $pendingPayments = Payment::query()
            ->where('status', Payment::STATUS_PENDING)
            ->count();

        $unreadContactMessages = ContactMessage::query()
            ->where('is_read', false)
            ->count();

        $totalSales = Order::query()
            ->whereIn('status', [
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_COMPLETED,
            ])
            ->sum('total_price');

        $latestOrders = Order::query()
            ->with('payment')
            ->latest()
            ->limit(5)
            ->get();

        $latestPayments = Payment::query()
            ->with('order')
            ->latest()
            ->limit(5)
            ->get();

        $latestMessages = ContactMessage::query()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalCustomers',
            'totalOrders',
            'lowStockBooks',
            'emptyStockBooks',
            'pendingPayments',
            'unreadContactMessages',
            'totalSales',
            'latestOrders',
            'latestPayments',
            'latestMessages'
        ));
    }
}
