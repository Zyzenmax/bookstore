<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder dijalankan berurutan karena seeder buku membutuhkan kategori.
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
