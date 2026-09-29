<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menampilkan halaman katalog buku untuk pembeli.
 */
class HomeController extends Controller
{
    /**
     * Menampilkan daftar buku dengan fitur pencarian dan penyaringan kategori.
     */
    public function index(Request $request): View
    {
        $keyword = trim($request->string('search')->value());
        $categoryId = (int) $request->integer('category');

        $books = Book::query()
            ->with('category')
            ->search($keyword)
            ->inCategory($categoryId > 0 ? $categoryId : null)
            ->orderBy('title')
            ->paginate(8)
            ->withQueryString();

        $categories = Category::query()
            ->withCount('books')
            ->orderBy('name')
            ->get();

        return view('store.home', compact('books', 'categories', 'keyword', 'categoryId'));
    }
}
