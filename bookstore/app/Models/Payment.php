<?php

namespace App\Models;

use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Catatan pembayaran simulasi untuk sebuah pesanan.
 */
#[Fillable(['order_id', 'payment_code', 'method', 'amount', 'status', 'paid_at'])]
class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    /** Kode metode pembayaran yang dipakai aplikasi. */
    public const METHOD_SIMULATION = 'simulasi';

    /**
     * Menentukan tipe data kolom yang perlu dikonversi otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Relasi pembayaran ke pesanan yang dibayar.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Membuat kode pembayaran unik dengan format PAY-YYYYMMDD-0001.
     */
    public static function generatePaymentCode(): string
    {
        $prefix = 'PAY-'.now()->format('Ymd').'-';

        // Urutan dihitung dari kode pembayaran terakhir pada tanggal yang sama.
        $lastPaymentCode = self::query()->where('payment_code', 'like', $prefix.'%')->max('payment_code');
        $sequence = $lastPaymentCode ? ((int) substr($lastPaymentCode, -4)) + 1 : 1;

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
