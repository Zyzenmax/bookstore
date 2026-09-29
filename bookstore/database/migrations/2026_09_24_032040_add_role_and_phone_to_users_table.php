<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom peran dan nomor telepon pada tabel pengguna.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Peran pengguna dipakai untuk membedakan admin dan pembeli.
            $table->string('role', 20)->default('user');
            // Nomor telepon bersifat opsional dan dipakai saat pengiriman pesanan.
            $table->string('phone', 20)->nullable();
        });
    }

    /**
     * Menghapus kolom peran dan nomor telepon.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone']);
        });
    }
};
