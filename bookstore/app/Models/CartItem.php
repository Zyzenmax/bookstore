<?php

namespace App\Models;

use Database\Factories\CartItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Satu baris buku di dalam keranjang belanja pengguna.
 */
#[Fillable(['user_id', 'book_id', 'quantity'])]
class CartItem extends Model
{
    /** @use HasFactory<CartItemFactory> */
    use HasFactory;

    /**
     * Menentukan tipe data kolom yang perlu dikonversi otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    /**
     * Relasi baris keranjang ke pemiliknya.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi baris keranjang ke buku yang dipilih.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Menghitung subtotal harga buku pada baris keranjang ini.
     */
    public function subtotal(): int
    {
        return $this->book->price * $this->quantity;
    }
}
