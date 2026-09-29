<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel keranjang belanja milik pengguna.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            // Pemilik keranjang belanja.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Buku yang dimasukkan ke keranjang.
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            // Banyaknya buku yang ingin dibeli.
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            // Satu pengguna hanya memiliki satu baris untuk setiap buku.
            $table->unique(['user_id', 'book_id']);
        });
    }

    /**
     * Menghapus tabel keranjang belanja.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
