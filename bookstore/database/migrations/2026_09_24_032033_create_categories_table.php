<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel kategori buku.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Nama kategori yang ditampilkan pada menu katalog.
            $table->string('name', 100)->unique();
            // Slug dipakai untuk alamat URL yang mudah dibaca.
            $table->string('slug', 120)->unique();
            // Keterangan singkat mengenai isi kategori.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel kategori buku.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
