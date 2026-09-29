<?php

namespace App\Support;

use Illuminate\Support\Number;

/**
 * Pemformat angka rupiah agar tampilan harga konsisten di seluruh halaman.
 */
class RupiahFormatter
{
    /**
     * Mengubah angka menjadi teks rupiah, misalnya 125000 menjadi Rp125.000.
     */
    public static function format(int|float|null $amount): string
    {
        // Nilai desimal tidak ditampilkan karena harga buku selalu bilangan bulat.
        return Number::currency((float) $amount, 'IDR', 'id', precision: 0);
    }
}
