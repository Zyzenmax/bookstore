<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Memastikan seluruh halaman utama dapat dibuka tanpa kesalahan tampilan.
 */
class PageSmokeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Halaman login dan pendaftaran dapat dibuka oleh tamu.
     */
    public function test_halaman_autentikasi_dapat_dibuka(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Masuk ke Akun');
        $this->get(route('register'))->assertOk()->assertSee('Daftar Akun Pembeli');
    }

    /**
     * Seluruh halaman pembeli dapat dibuka setelah masuk.
     */
    public function test_seluruh_halaman_pembeli_dapat_dibuka(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create();

        CartItem::factory()->create([
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
        ]);

        $pesanan = Order::factory()->create(['user_id' => $pembeli->id]);

        $this->actingAs($pembeli)->get(route('store.books.index'))->assertOk();
        $this->actingAs($pembeli)->get(route('store.books.show', $buku))->assertOk();
        $this->actingAs($pembeli)->get(route('store.cart.index'))->assertOk();
        $this->actingAs($pembeli)->get(route('store.checkout.index'))->assertOk();
        $this->actingAs($pembeli)->get(route('store.orders.index'))->assertOk();
        $this->actingAs($pembeli)->get(route('store.orders.show', $pesanan))->assertOk();
        $this->actingAs($pembeli)->get(route('store.pages.contact'))->assertOk();
    }

    /**
     * Seluruh halaman admin dapat dibuka oleh administrator.
     */
    public function test_seluruh_halaman_admin_dapat_dibuka(): void
    {
        $admin = User::factory()->admin()->create();
        $kategori = Category::factory()->create();
        $buku = Book::factory()->create(['category_id' => $kategori->id]);
        $pesanan = Order::factory()->paid()->create();
        $pesan = ContactMessage::factory()->create();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();

        $this->actingAs($admin)->get(route('admin.categories.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.categories.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.categories.edit', $kategori))->assertOk();

        $this->actingAs($admin)->get(route('admin.books.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.books.create'))->assertOk();
        $this->actingAs($admin)->get(route('admin.books.edit', $buku))->assertOk();

        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.orders.show', $pesanan))->assertOk();
        $this->actingAs($admin)->get(route('admin.messages.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.messages.show', $pesan))->assertOk();
    }
}
