<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Pembuat slug unik untuk data yang memiliki alamat halaman sendiri.
 */
class UniqueSlug
{
    /**
     * Membuat slug unik dari sebuah teks untuk model tertentu.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function make(string $text, string $modelClass, ?int $ignoredId = null): string
    {
        $baseSlug = Str::slug($text);
        $slug = $baseSlug;
        $counter = 1;

        // Selama slug masih dipakai data lain, tambahkan angka urut di belakangnya.
        while (self::isSlugUsed($slug, $modelClass, $ignoredId)) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Memeriksa apakah slug sudah dipakai oleh data lain.
     *
     * @param  class-string<Model>  $modelClass
     */
    private static function isSlugUsed(string $slug, string $modelClass, ?int $ignoredId): bool
    {
        return $modelClass::query()
            ->where('slug', $slug)
            ->when($ignoredId !== null, fn ($query) => $query->whereKeyNot($ignoredId))
            ->exists();
    }
}
