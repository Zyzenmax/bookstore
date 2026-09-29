<?php

namespace App\Models;

use Database\Factories\OrderItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Rincian buku yang termasuk pada sebuah pesanan.
 */
#[Fillable(['order_id', 'book_id', 'book_title', 'price', 'quantity', 'subtotal'])]
class OrderItem extends Model
{
    /** @use HasFactory<OrderItemFactory> */
    use HasFactory;

    /**
     * Menentukan tipe data kolom yang perlu dikonversi otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'quantity' => 'integer',
            'subtotal' => 'integer',
        ];
    }

    /**
     * Relasi rincian ke pesanan induknya.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi rincian ke buku yang dipesan.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
