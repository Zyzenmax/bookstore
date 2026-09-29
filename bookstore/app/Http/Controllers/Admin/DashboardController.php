<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use App\UserRole;
use Illuminate\View\View;

/**
 * Menampilkan ringkasan data toko pada dasbor admin.
 */
class DashboardController extends Controller
{
    /**
     * Menyusun statistik singkat dan pesanan terbaru untuk dipantau admin.
     */
    public function index(): View
    {
        $statistics = [
            'total_books' => Book::query()->count(),
            'total_categories' => Category::query()->count(),
            'total_customers' => User::query()->where('role', UserRole::User)->count(),
            'total_orders' => Order::query()->count(),
            'unpaid_orders' => Order::query()->where('status', OrderStatus::Pending)->count(),
            'unread_messages' => ContactMessage::query()->unread()->count(),
            // Total pendapatan dihitung dari pesanan yang sudah dibayar.
            'total_revenue' => (int) Order::query()->where('status', OrderStatus::Paid)->sum('total_price'),
        ];

        // Lima pesanan terbaru ditampilkan agar admin cepat mengetahuinya.
        $latestOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('statistics', 'latestOrders'));
    }
}
