<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Mengisi data awal kategori buku.
 */
class CategorySeeder extends Seeder
{
    /**
     * Daftar kategori bawaan aplikasi.
     *
     * @var array<int, array{name: string, description: string}>
     */
    private const CATEGORIES = [
        ['name' => 'Fiksi & Sastra', 'description' => 'Novel dan cerita fiksi dari penulis ternama dunia.'],
        ['name' => 'Sastra Klasik', 'description' => 'Karya sastra klasik yang tetap dibaca sepanjang masa.'],
        ['name' => 'Anak & Remaja', 'description' => 'Buku cerita ringan yang cocok untuk pembaca muda.'],
        ['name' => 'Sejarah, Politik & Filsafat', 'description' => 'Buku sejarah, pemikiran politik, dan filsafat.'],
        ['name' => 'Sains & Teknologi', 'description' => 'Buku ilmu pengetahuan alam dan perkembangan teknologi.'],
        ['name' => 'Bisnis & Ekonomi', 'description' => 'Buku ekonomi, keuangan, dan strategi berbisnis.'],
    ];

    /**
     * Menyimpan seluruh kategori bawaan aplikasi.
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $category) {
            // updateOrCreate menjaga seeder tetap aman dijalankan berulang kali.
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );
        }
    }
}
