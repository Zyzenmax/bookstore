<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji fitur keranjang belanja pembeli.
 */
class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pembeli dapat menambahkan buku ke keranjang belanja.
     */
    public function test_pembeli_dapat_menambahkan_buku_ke_keranjang(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['stock' => 5]);

        $respons = $this->actingAs($pembeli)->post(route('store.cart.store', $buku), [
            'quantity' => 2,
        ]);

        $respons->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 2,
        ]);
    }

    /**
     * Buku yang sama ditambahkan lagi cukup menambah jumlahnya.
     */
    public function test_penambahan_buku_yang_sama_menambah_jumlah(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['stock' => 5]);

        CartItem::factory()->create([
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 1,
        ]);

        $this->actingAs($pembeli)->post(route('store.cart.store', $buku), ['quantity' => 2]);

        $this->assertDatabaseHas('cart_items', [
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 3,
        ]);
    }

    /**
     * Jumlah yang melebihi stok buku ditolak.
     */
    public function test_jumlah_melebihi_stok_ditolak(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['stock' => 2]);

        $respons = $this->actingAs($pembeli)->post(route('store.cart.store', $buku), [
            'quantity' => 5,
        ]);

        $respons->assertSessionHas('error');
        $this->assertDatabaseCount('cart_items', 0);
    }

    /**
     * Buku yang stoknya habis tidak dapat dimasukkan ke keranjang.
     */
    public function test_buku_stok_habis_tidak_dapat_dimasukkan(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->outOfStock()->create();

        $respons = $this->actingAs($pembeli)->post(route('store.cart.store', $buku), [
            'quantity' => 1,
        ]);

        $respons->assertSessionHas('error');
        $this->assertDatabaseCount('cart_items', 0);
    }

    /**
     * Pembeli dapat mengubah jumlah buku pada keranjangnya.
     */
    public function test_pembeli_dapat_mengubah_jumlah_di_keranjang(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['stock' => 10]);

        $itemKeranjang = CartItem::factory()->create([
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 1,
        ]);

        $respons = $this->actingAs($pembeli)->patch(
            route('store.cart.update', $itemKeranjang),
            ['quantity' => 4]
        );

        $respons->assertRedirect(route('store.cart.index'));
        $this->assertDatabaseHas('cart_items', [
            'id' => $itemKeranjang->id,
            'quantity' => 4,
        ]);
    }

    /**
     * Pembeli tidak boleh mengubah keranjang milik pembeli lain.
     */
    public function test_pembeli_tidak_dapat_mengubah_keranjang_milik_pembeli_lain(): void
    {
        $itemKeranjang = CartItem::factory()->create(['quantity' => 1]);

        $respons = $this->actingAs(User::factory()->create())->patch(
            route('store.cart.update', $itemKeranjang),
            ['quantity' => 2]
        );

        $respons->assertForbidden();
    }

    /**
     * Pembeli tidak boleh menghapus isi keranjang milik pembeli lain.
     */
    public function test_pembeli_tidak_dapat_menghapus_keranjang_milik_pembeli_lain(): void
    {
        $itemKeranjang = CartItem::factory()->create();

        $respons = $this->actingAs(User::factory()->create())
            ->delete(route('store.cart.destroy', $itemKeranjang));

        $respons->assertForbidden();
        $this->assertDatabaseHas('cart_items', ['id' => $itemKeranjang->id]);
    }
}
