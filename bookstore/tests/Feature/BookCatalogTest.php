<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji halaman katalog buku untuk pembeli.
 */
class BookCatalogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pembeli dapat melihat daftar buku pada halaman katalog.
     */
    public function test_pembeli_dapat_melihat_daftar_buku(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['title' => 'Buku Uji Katalog']);

        $respons = $this->actingAs($pembeli)->get(route('store.books.index'));

        $respons->assertOk();
        $respons->assertSee('Buku Uji Katalog');
        $respons->assertSee('Katalog Buku');
    }

    /**
     * Pencarian menyaring daftar buku berdasarkan judul atau pengarang.
     */
    public function test_pencarian_menyaring_daftar_buku(): void
    {
        $pembeli = User::factory()->create();

        Book::factory()->create(['title' => 'Sejarah Nusantara']);
        Book::factory()->create(['title' => 'Panduan Memasak']);

        $respons = $this->actingAs($pembeli)->get(route('store.books.index', ['search' => 'Nusantara']));

        $respons->assertOk();
        $respons->assertSee('Sejarah Nusantara');
        $respons->assertDontSee('Panduan Memasak');
    }

    /**
     * Penyaringan kategori hanya menampilkan buku pada kategori tersebut.
     */
    public function test_penyaringan_kategori_menampilkan_buku_sejenis(): void
    {
        $pembeli = User::factory()->create();
        $kategori = Category::factory()->create();

        $bukuSejenis = Book::factory()->create([
            'category_id' => $kategori->id,
            'title' => 'Buku Kategori Terpilih',
        ]);

        Book::factory()->create(['title' => 'Buku Kategori Lain']);

        $respons = $this->actingAs($pembeli)->get(
            route('store.books.index', ['category' => $kategori->id])
        );

        $respons->assertOk();
        $respons->assertSee('Buku Kategori Terpilih');
        $respons->assertDontSee('Buku Kategori Lain');
        $respons->assertSee($bukuSejenis->author);
    }

    /**
     * Halaman rincian buku menampilkan informasi lengkap buku.
     */
    public function test_pembeli_dapat_melihat_rincian_buku(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['title' => 'Buku Rincian Uji', 'stock' => 5]);

        $respons = $this->actingAs($pembeli)->get(route('store.books.show', $buku));

        $respons->assertOk();
        $respons->assertSee('Buku Rincian Uji');
        $respons->assertSee('Tambah ke Keranjang');
    }

    /**
     * Tamu yang membuka katalog diarahkan ke halaman login.
     */
    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('store.books.index'))->assertRedirect(route('login'));
    }
}
