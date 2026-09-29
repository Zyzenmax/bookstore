<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Memantau pesanan buku yang dibuat oleh seluruh pengguna.
 */
class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan beserta penyaringan status pembayaran.
     */
    public function index(Request $request): View
    {
        $status = $request->string('status')->value();

        $orders = Order::query()
            ->with('user')
            ->withCount('items')
            ->when(
                in_array($status, OrderStatus::cases(), true),
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    /**
     * Menampilkan rincian satu pesanan beserta data pembayarannya.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'items.book', 'payment']);

        return view('admin.orders.show', compact('order'));
    }
}
