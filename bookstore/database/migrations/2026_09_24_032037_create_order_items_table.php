<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel rincian buku pada setiap pesanan.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // Pesanan induk dari rincian ini.
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            // Buku yang dipesan. Rincian tetap tersimpan bila buku dihapus.
            $table->foreignId('book_id')->nullable()->constrained('books')->nullOnDelete();
            // Judul buku disalin agar riwayat pesanan tidak berubah.
            $table->string('book_title', 180);
            // Harga satuan saat transaksi terjadi.
            $table->unsignedInteger('price');
            $table->unsignedInteger('quantity');
            // Subtotal adalah harga dikalikan jumlah buku.
            $table->unsignedInteger('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel rincian pesanan.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
