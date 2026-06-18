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
        $lowStockBooks = Book::query()->where('stock', '<=', 5)->count();
        $pendingPayments = Payment::query()->where('status', Payment::STATUS_PENDING)->count();
        $unreadContactMessages = ContactMessage::query()
                ->where('is_read', false)
                ->count();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalCategories',
            'totalCustomers',
            'totalOrders',
            'lowStockBooks',
            'pendingPayments',
            'unreadContactMessages'
        ));
    }
}
