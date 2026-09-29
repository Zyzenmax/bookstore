<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Menguji pembayaran simulasi beserta status pesanannya.
 */
class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pembayaran simulasi menandai pesanan sudah dibayar dan menyimpan bukti.
     */
    public function test_pembayaran_simulasi_menandai_pesanan_sudah_dibayar(): void
    {
        $pembeli = User::factory()->create();
        $pesanan = Order::factory()->create([
            'user_id' => $pembeli->id,
            'total_price' => 150000,
        ]);

        $respons = $this->actingAs($pembeli)->post(route('store.orders.pay', $pesanan));

        $respons->assertRedirect(route('store.orders.payment-success', $pesanan));

        $this->assertDatabaseHas('orders', [
            'id' => $pesanan->id,
            'status' => OrderStatus::Paid->value,
        ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => $pesanan->id,
            'amount' => 150000,
            'method' => 'simulasi',
            'status' => 'success',
        ]);

        $this->assertNotNull($pesanan->fresh()->paid_at);
    }

    /**
     * Pesanan milik pembeli lain tidak dapat dibayar.
     */
    public function test_pembeli_lain_tidak_dapat_membayar_pesanan_orang_lain(): void
    {
        $pesanan = Order::factory()->create();

        $respons = $this->actingAs(User::factory()->create())
            ->post(route('store.orders.pay', $pesanan));

        $respons->assertForbidden();
        $this->assertDatabaseCount('payments', 0);
    }

    /**
     * Halaman bukti pembayaran menampilkan status lunas.
     */
    public function test_halaman_bukti_pembayaran_menampilkan_status_lunas(): void
    {
        $pembeli = User::factory()->create();
        $pesanan = Order::factory()->paid()->create(['user_id' => $pembeli->id]);

        $respons = $this->actingAs($pembeli)->get(route('store.orders.payment-success', $pesanan));

        $respons->assertOk();
        $respons->assertSee('Pembayaran Berhasil');
        $respons->assertSee('SUDAH DIBAYAR');
    }

    /**
     * Halaman bukti pembayaran tidak dapat dibuka untuk pesanan yang belum dibayar.
     */
    public function test_pesanan_belum_dibayar_dialihkan_dari_halaman_bukti(): void
    {
        $pembeli = User::factory()->create();
        $pesanan = Order::factory()->create(['user_id' => $pembeli->id]);

        $respons = $this->actingAs($pembeli)->get(route('store.orders.payment-success', $pesanan));

        $respons->assertRedirect(route('store.orders.show', $pesanan));
    }
}
