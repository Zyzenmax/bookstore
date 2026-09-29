<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel pesan dari pengguna kepada admin.
     */
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            // Pengirim pesan. Bernilai kosong bila akun pengirim dihapus.
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sender_name', 120);
            $table->string('sender_email', 180);
            $table->string('subject', 180);
            $table->text('message');
            // Penanda bahwa admin sudah membaca pesan tersebut.
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel pesan pengguna.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
