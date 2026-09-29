<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel pembayaran simulasi.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Pesanan yang dibayar melalui simulasi ini.
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // Kode pembayaran menjadi bukti transaksi simulasi.
            $table->string('payment_code', 40)->unique();
            // Aplikasi ini hanya memakai metode pembayaran simulasi.
            $table->string('method', 30)->default('simulasi');
            $table->unsignedInteger('amount');
            // Status pembayaran simulasi: success atau failed.
            $table->string('status', 20)->default('success');
            $table->timestamp('paid_at');
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel pembayaran simulasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
