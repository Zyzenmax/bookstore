<?php

namespace App;

/**
 * Status pesanan yang dipakai pada proses pembayaran simulasi.
 */
enum OrderStatus: string
{
    /** Pesanan sudah dibuat namun belum dibayar. */
    case Pending = 'pending';

    /** Pesanan sudah dibayar melalui simulasi pembayaran. */
    case Paid = 'paid';

    /** Pesanan dibatalkan sehingga tidak perlu dibayar. */
    case Cancelled = 'cancelled';

    /**
     * Label status dalam bahasa Indonesia untuk ditampilkan pada halaman web.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Pembayaran',
            self::Paid => 'Sudah Dibayar',
            self::Cancelled => 'Dibatalkan',
        };
    }

    /**
     * Kelas warna Bootstrap yang dipakai pada komponen badge status.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning text-dark',
            self::Paid => 'bg-success',
            self::Cancelled => 'bg-secondary',
        };
    }
}
