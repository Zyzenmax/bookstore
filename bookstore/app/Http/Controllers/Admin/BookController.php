<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Support\UniqueSlug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

/**
 * Mengelola data buku pada halaman admin.
 */
class BookController extends Controller
{
    /**
     * Folder penyimpanan gambar sampul buku.
     */
    private const COVER_FOLDER = 'images/books';

    /**
     * Menampilkan daftar buku beserta pencarian dan penyaringan kategori.
     */
    public function index(Request $request): View
    {
        $keyword = trim($request->string('search')->value());
        $categoryId = (int) $request->integer('category');

        $books = Book::query()
            ->with('category')
            ->search($keyword)
            ->inCategory($categoryId > 0 ? $categoryId : null)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('admin.books.index', compact('books', 'categories', 'keyword', 'categoryId'));
    }

    /**
     * Menampilkan formulir penambahan buku.
     */
    public function create(): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Menyimpan buku baru beserta gambar sampulnya.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = UniqueSlug::make($data['title'], Book::class);

        Book::create([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'author' => $data['author'],
            'publisher' => $data['publisher'] ?? null,
            'published_year' => $data['published_year'] ?? null,
            'isbn' => $data['isbn'] ?? null,
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
            'description' => $data['description'] ?? null,
            // Sampul hanya disimpan bila admin mengunggah berkas gambar.
            'cover_image' => $request->hasFile('cover_image')
                ? $this->saveCoverImage($request->file('cover_image'), $slug)
                : null,
        ]);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir perubahan data buku.
     */
    public function edit(Book $book): View
    {
        $categories = Category::query()->orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Menyimpan perubahan data buku.
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $data = $request->validated();
        $coverImage = $book->cover_image;

        // Sampul lama diganti hanya bila admin mengunggah berkas baru.
        if ($request->hasFile('cover_image')) {
            $this->deleteCoverImage($coverImage);
            $coverImage = $this->saveCoverImage($request->file('cover_image'), $book->slug);
        }

        $book->update([
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'author' => $data['author'],
            'publisher' => $data['publisher'] ?? null,
            'published_year' => $data['published_year'] ?? null,
            'isbn' => $data['isbn'] ?? null,
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
            'description' => $data['description'] ?? null,
            'cover_image' => $coverImage,
        ]);

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Menghapus buku beserta gambar sampulnya.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $this->deleteCoverImage($book->cover_image);
        $book->delete();

        return redirect()
            ->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Menyimpan berkas sampul ke folder public/images/books.
     */
    private function saveCoverImage(UploadedFile $coverImage, string $slug): string
    {
        // Nama berkas memakai slug buku agar mudah dikenali.
        $fileName = $slug.'.'.$coverImage->getClientOriginalExtension();
        $coverImage->move(public_path(self::COVER_FOLDER), $fileName);

        return $fileName;
    }

    /**
     * Menghapus berkas sampul lama bila ada.
     */
    private function deleteCoverImage(?string $fileName): void
    {
        if ($fileName === null) {
            return;
        }

        $filePath = public_path(self::COVER_FOLDER.'/'.$fileName);

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}
