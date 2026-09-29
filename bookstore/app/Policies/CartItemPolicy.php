<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\User;

/**
 * Aturan hak akses untuk isi keranjang belanja.
 */
class CartItemPolicy
{
    /**
     * Menentukan apakah pengguna boleh mengubah jumlah buku di keranjangnya.
     */
    public function update(User $user, CartItem $cartItem): bool
    {
        return $user->id === $cartItem->user_id;
    }

    /**
     * Menentukan apakah pengguna boleh menghapus buku dari keranjangnya.
     */
    public function delete(User $user, CartItem $cartItem): bool
    {
        return $user->id === $cartItem->user_id;
    }
}
