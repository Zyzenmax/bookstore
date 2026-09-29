<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use App\Support\RupiahFormatter;
use App\UserRole;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

/**
 * Menampilkan ringkasan data toko buku dalam bentuk teks pada terminal.
 */
#[Signature('bookstore:ringkasan')]
#[Description('Menampilkan ringkasan jumlah buku, pengguna, dan pesanan toko buku')]
class ShowBookStoreSummary extends Command
{
    /**
     * Menjalankan perintah dan mencetak laporan ringkas.
     */
    public function handle(): int
    {
        // Ringkasan umum ditampilkan lebih dahulu.
        $this->info('Ringkasan Toko Buku');
        $this->newLine();

        $this->table(
            ['Keterangan', 'Jumlah'],
            [
                ['Kategori buku', (string) Category::query()->count()],
                ['Judul buku', (string) Book::query()->count()],
                ['Total stok buku', (string) Book::query()->sum('stock')],
                ['Akun pembeli', (string) User::query()->where('role', UserRole::User)->count()],
                ['Pesanan', (string) Order::query()->count()],
                ['Pesanan belum dibayar', (string) Order::query()->where('status', OrderStatus::Pending)->count()],
                ['Pendapatan pesanan lunas', RupiahFormatter::format((int) Order::query()->where('status', OrderStatus::Paid)->sum('total_price'))],
            ]
        );

        $this->newLine();
        $this->info('Daftar buku beserta stoknya');
        $this->newLine();

        // Daftar buku diurutkan berdasarkan stok terkecil agar cepat ditindaklanjuti.
        $books = Book::query()->orderBy('stock')->get();

        $rows = $books->map(fn (Book $book): array => [
            $book->title,
            $book->author,
            (string) $book->stock,
            RupiahFormatter::format($book->price),
        ])->all();

        $this->table(['Judul', 'Pengarang', 'Stok', 'Harga'], $rows);

        return self::SUCCESS;
    }
}
