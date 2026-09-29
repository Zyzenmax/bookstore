<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Seeder;

/**
 * Mengisi akun awal untuk admin dan pembeli contoh.
 */
class UserSeeder extends Seeder
{
    /**
     * Membuat satu akun admin dan dua akun pembeli.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bookstore.test'],
            [
                'name' => 'Admin Toko Buku',
                'phone' => '081234567890',
                'password' => 'password',
                'role' => UserRole::Admin,
            ]
        );

        User::updateOrCreate(
            ['email' => 'pembeli@bookstore.test'],
            [
                'name' => 'Budi Pembeli',
                'phone' => '081298765432',
                'password' => 'password',
                'role' => UserRole::User,
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@bookstore.test'],
            [
                'name' => 'Siti Rahma',
                'phone' => '081311223344',
                'password' => 'password',
                'role' => UserRole::User,
            ]
        );
    }
}
