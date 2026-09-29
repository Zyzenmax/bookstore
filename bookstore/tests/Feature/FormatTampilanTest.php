<?php

namespace Tests\Feature;

use App\Support\RupiahFormatter;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * Menguji tampilan teks berbahasa Indonesia pada aplikasi.
 */
class FormatTampilanTest extends TestCase
{
    /**
     * Nama bulan mengikuti bahasa Indonesia.
     */
    public function test_nama_bulan_memakai_bahasa_indonesia(): void
    {
        $tanggal = Carbon::create(2026, 1, 15);

        $this->assertSame('15 Januari 2026', $tanggal->translatedFormat('d F Y'));
    }

    /**
     * Harga ditampilkan dalam format rupiah tanpa angka desimal.
     *
     * Pemisah setelah tulisan Rp memakai spasi khusus (non-breaking space)
     * yang merupakan bawaan pemformat mata uang.
     */
    public function test_harga_ditampilkan_dalam_format_rupiah(): void
    {
        $this->assertSame("Rp\u{00A0}125.000", RupiahFormatter::format(125000));
        $this->assertSame("Rp\u{00A0}0", RupiahFormatter::format(null));
    }
}
