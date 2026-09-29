<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Mengelola pesanan dan pembayaran simulasi milik pembeli.
 */
class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik pengguna yang sedang masuk.
     */
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->withCount('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('store.orders.index', compact('orders'));
    }

    /**
     * Menampilkan rincian satu pesanan beserta status pembayarannya.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load(['items.book', 'payment']);

        return view('store.orders.show', compact('order'));
    }

    /**
     * Menjalankan pembayaran simulasi untuk sebuah pesanan.
     */
    public function pay(Order $order): RedirectResponse
    {
        $this->authorize('pay', $order);

        // Pembayaran simulasi: pesanan langsung ditandai sudah dibayar
        // tanpa menghubungkan aplikasi ke penyedia pembayaran mana pun.
        DB::transaction(function () use ($order): void {
            $order->update([
                'status' => OrderStatus::Paid,
                'paid_at' => now(),
            ]);

            $order->payment()->create([
                'payment_code' => Payment::generatePaymentCode(),
                'method' => Payment::METHOD_SIMULATION,
                'amount' => $order->total_price,
                'status' => 'success',
                'paid_at' => now(),
            ]);
        });

        return redirect()
            ->route('store.orders.payment-success', $order)
            ->with('success', 'Pembayaran simulasi berhasil diproses.');
    }

    /**
     * Menampilkan bukti keberhasilan pembayaran simulasi.
     */
    public function paymentSuccess(Order $order): View|RedirectResponse
    {
        $this->authorize('view', $order);

        $order->load('payment');

        // Halaman ini hanya boleh dibuka untuk pesanan yang sudah dibayar.
        if (! $order->isPaid()) {
            return redirect()
                ->route('store.orders.show', $order)
                ->with('error', 'Pesanan tersebut belum dibayar.');
        }

        return view('store.orders.payment-success', compact('order'));
    }
}
