<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji proses checkout keranjang menjadi pesanan.
 */
class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checkout membuat pesanan, rincian pesanan, dan mengurangi stok buku.
     */
    public function test_checkout_membuat_pesanan_dan_mengurangi_stok(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['price' => 50000, 'stock' => 10]);

        CartItem::factory()->create([
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 2,
        ]);

        $respons = $this->actingAs($pembeli)->post(route('store.checkout.store'), [
            'customer_name' => 'Budi Pembeli',
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jalan Merdeka Nomor 1, Banda Aceh',
            'note' => 'Mohon dibungkus rapi.',
        ]);

        $pesanan = Order::query()->firstOrFail();

        $respons->assertRedirect(route('store.orders.show', $pesanan));

        $this->assertDatabaseHas('orders', [
            'user_id' => $pembeli->id,
            'total_price' => 100000,
            'status' => OrderStatus::Pending->value,
        ]);

        $this->assertDatabaseHas('order_items', [
            'book_title' => $buku->title,
            'quantity' => 2,
            'subtotal' => 100000,
        ]);

        // Stok berkurang sesuai jumlah pembelian dan keranjang dikosongkan.
        $this->assertSame(8, $buku->fresh()->stock);
        $this->assertDatabaseCount('cart_items', 0);
    }

    /**
     * Checkout tidak dapat dilakukan ketika keranjang masih kosong.
     */
    public function test_checkout_dengan_keranjang_kosong_ditolak(): void
    {
        $pembeli = User::factory()->create();

        $respons = $this->actingAs($pembeli)->post(route('store.checkout.store'), [
            'customer_name' => 'Budi Pembeli',
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jalan Merdeka Nomor 1, Banda Aceh',
        ]);

        $respons->assertRedirect(route('store.cart.index'));
        $respons->assertSessionHas('error');
        $this->assertDatabaseCount('orders', 0);
    }

    /**
     * Checkout yang melebihi stok dibatalkan dan tidak menyimpan pesanan.
     */
    public function test_checkout_melebihi_stok_dibatalkan(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['price' => 40000, 'stock' => 5]);

        // Keranjang dibuat melebihi stok untuk menguji pemeriksaan ulang.
        CartItem::factory()->create([
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 5,
        ]);

        $buku->update(['stock' => 1]);

        $this->actingAs($pembeli)->post(route('store.checkout.store'), [
            'customer_name' => 'Budi Pembeli',
            'customer_phone' => '081234567890',
            'shipping_address' => 'Jalan Merdeka Nomor 1, Banda Aceh',
        ])->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(1, $buku->fresh()->stock);
    }

    /**
     * Formulir checkout menampilkan ringkasan keranjang.
     */
    public function test_halaman_checkout_menampilkan_ringkasan_keranjang(): void
    {
        $pembeli = User::factory()->create();
        $buku = Book::factory()->create(['price' => 30000, 'stock' => 5]);

        CartItem::factory()->create([
            'user_id' => $pembeli->id,
            'book_id' => $buku->id,
            'quantity' => 1,
        ]);

        $respons = $this->actingAs($pembeli)->get(route('store.checkout.index'));

        $respons->assertOk();
        $respons->assertSee($buku->title);
        $respons->assertSee('Checkout Pesanan');
    }
}
