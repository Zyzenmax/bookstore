<?php

namespace App\Models;

use App\OrderStatus;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Pesanan buku yang dibuat oleh pengguna.
 */
#[Fillable([
    'user_id', 'order_number', 'status', 'total_price',
    'customer_name', 'customer_phone', 'shipping_address', 'note', 'paid_at',
])]
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    /** Awalan nomor pesanan yang dipakai aplikasi. */
    public const NUMBER_PREFIX = 'INV-';

    /**
     * Menentukan tipe data kolom yang perlu dikonversi otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'total_price' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Relasi pesanan ke pengguna yang membuatnya.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi pesanan ke rincian buku yang dibeli.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi pesanan ke pembayaran simulasi yang menyertainya.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Membuat nomor pesanan unik dengan format INV-YYYYMMDD-0001.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = self::NUMBER_PREFIX.now()->format('Ymd').'-';

        // Urutan dihitung dari nomor pesanan terakhir pada tanggal yang sama.
        $lastOrderNumber = self::query()->where('order_number', 'like', $prefix.'%')->max('order_number');
        $sequence = $lastOrderNumber ? ((int) substr($lastOrderNumber, -4)) + 1 : 1;

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Memeriksa apakah pesanan sudah dibayar.
     */
    public function isPaid(): bool
    {
        return $this->status === OrderStatus::Paid;
    }

    /**
     * Menghitung jumlah seluruh buku yang dipesan.
     */
    public function totalQuantity(): int
    {
        return (int) $this->items->sum('quantity');
    }
}
