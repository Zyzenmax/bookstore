<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji data awal (seeder) yang disiapkan untuk aplikasi.
 */
class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Seeder mengisi kategori, buku, akun contoh, dan gambar sampulnya.
     */
    public function test_seeder_mengisi_katalog_buku_dan_gambar_sampul(): void
    {
        $this->seed();

        $this->assertSame(6, Category::query()->count());
        $this->assertSame(18, Book::query()->count());

        // Setiap buku harus memiliki berkas gambar sampul pada folder public.
        Book::query()->each(function (Book $book): void {
            $this->assertFileExists(public_path('images/books/'.$book->cover_image));
        });

        $this->assertDatabaseHas('users', [
            'email' => 'admin@bookstore.test',
            'role' => 'admin',
        ]);
    }
}
