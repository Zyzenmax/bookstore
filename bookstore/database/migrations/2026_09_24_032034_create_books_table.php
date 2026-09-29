<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel data buku.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel kategori. Buku ikut terhapus bila kategorinya dihapus.
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('author', 120);
            // Nama penerbit bersifat opsional.
            $table->string('publisher', 120)->nullable();
            // Tahun terbit disimpan sebagai angka empat digit.
            $table->unsignedSmallInteger('published_year')->nullable();
            $table->string('isbn', 20)->nullable();
            // Harga dan stok memakai bilangan bulat agar mudah dihitung.
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock');
            $table->text('description')->nullable();
            // Nama berkas gambar sampul pada folder public/images/books.
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel data buku.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
