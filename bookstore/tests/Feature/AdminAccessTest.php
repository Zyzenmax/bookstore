<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji hak akses dan fitur pengelolaan data pada area admin.
 */
class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pembeli tidak boleh membuka halaman admin.
     */
    public function test_pembeli_tidak_dapat_membuka_halaman_admin(): void
    {
        $respons = $this->actingAs(User::factory()->create())->get(route('admin.dashboard'));

        $respons->assertForbidden();
    }

    /**
     * Admin dapat membuka dasbor admin.
     */
    public function test_admin_dapat_membuka_dasbor(): void
    {
        $respons = $this->actingAs(User::factory()->admin()->create())->get(route('admin.dashboard'));

        $respons->assertOk();
        $respons->assertSee('Dasbor Admin');
    }

    /**
     * Admin dapat menambahkan kategori baru beserta slug otomatisnya.
     */
    public function test_admin_dapat_menambahkan_kategori(): void
    {
        $respons = $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.categories.store'), [
                'name' => 'Kategori Baru',
                'description' => 'Keterangan kategori baru.',
            ]);

        $respons->assertRedirect(route('admin.categories.index'));

        $this->assertDatabaseHas('categories', [
            'name' => 'Kategori Baru',
            'slug' => 'kategori-baru',
        ]);
    }

    /**
     * Kategori yang masih memiliki buku tidak boleh dihapus.
     */
    public function test_admin_tidak_dapat_menghapus_kategori_yang_masih_memiliki_buku(): void
    {
        $kategori = Category::factory()->create();
        Book::factory()->create(['category_id' => $kategori->id]);

        $respons = $this->actingAs(User::factory()->admin()->create())
            ->delete(route('admin.categories.destroy', $kategori));

        $respons->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $kategori->id]);
    }

    /**
     * Admin dapat menambahkan buku baru.
     */
    public function test_admin_dapat_menambahkan_buku(): void
    {
        $kategori = Category::factory()->create();

        $respons = $this->actingAs(User::factory()->admin()->create())
            ->post(route('admin.books.store'), [
                'category_id' => $kategori->id,
                'title' => 'Buku Baru Dari Admin',
                'author' => 'Penulis Uji',
                'price' => 90000,
                'stock' => 3,
            ]);

        $respons->assertRedirect(route('admin.books.index'));

        $this->assertDatabaseHas('books', [
            'title' => 'Buku Baru Dari Admin',
            'slug' => 'buku-baru-dari-admin',
            'stock' => 3,
        ]);
    }

    /**
     * Admin dapat melihat daftar pengguna yang sudah mendaftar.
     */
    public function test_admin_dapat_melihat_daftar_pengguna(): void
    {
        User::factory()->create(['name' => 'Pembeli Terdaftar']);

        $respons = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.users.index'));

        $respons->assertOk();
        $respons->assertSee('Pembeli Terdaftar');
    }
}
