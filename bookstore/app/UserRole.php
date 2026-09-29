<?php

namespace App;

/**
 * Peran pengguna yang menentukan hak akses di dalam aplikasi.
 */
enum UserRole: string
{
    /** Administrator yang mengelola kategori, buku, pengguna, dan pesanan. */
    case Admin = 'admin';

    /** Pembeli yang menjelajah katalog, mengisi keranjang, dan membuat pesanan. */
    case User = 'user';

    /**
     * Label peran dalam bahasa Indonesia untuk ditampilkan pada halaman web.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::User => 'Pembeli',
        };
    }
}
