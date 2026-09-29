<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\View\View;

/**
 * Menampilkan rincian sebuah buku kepada pembeli.
 */
class BookController extends Controller
{
    /**
     * Menampilkan rincian buku beserta buku lain pada kategori yang sama.
     */
    public function show(Book $book): View
    {
        $book->load('category');

        // Buku lain pada kategori yang sama dipakai sebagai rekomendasi.
        $relatedBooks = Book::query()
            ->with('category')
            ->where('category_id', $book->category_id)
            ->whereKeyNot($book->id)
            ->take(4)
            ->get();

        return view('store.books.show', compact('book', 'relatedBooks'));
    }
}
