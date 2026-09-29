<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel pesanan buku.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Pengguna yang membuat pesanan.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Nomor pesanan menjadi identitas pesanan pada halaman pembayaran.
            $table->string('order_number', 30)->unique();
            // Status pesanan: pending, paid, atau cancelled.
            $table->string('status', 20)->default('pending');
            // Total harga seluruh buku pada pesanan ini.
            $table->unsignedInteger('total_price');
            // Data penerima yang diisi saat checkout.
            $table->string('customer_name', 120);
            $table->string('customer_phone', 20);
            $table->text('shipping_address');
            $table->text('note')->nullable();
            // Waktu pembayaran berhasil dilakukan.
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel pesanan buku.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
