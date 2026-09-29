<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

/**
 * Aturan hak akses untuk melihat dan membayar pesanan.
 */
class OrderPolicy
{
    /**
     * Menentukan siapa saja yang boleh melihat rincian sebuah pesanan.
     */
    public function view(User $user, Order $order): bool
    {
        // Pemilik pesanan dan admin boleh membuka rincian pesanan.
        return $user->id === $order->user_id || $user->isAdmin();
    }

    /**
     * Menentukan siapa saja yang boleh membayar sebuah pesanan.
     */
    public function pay(User $user, Order $order): bool
    {
        // Hanya pemilik pesanan yang belum dibayar yang boleh melanjutkan pembayaran.
        return $user->id === $order->user_id && ! $order->isPaid();
    }
}
