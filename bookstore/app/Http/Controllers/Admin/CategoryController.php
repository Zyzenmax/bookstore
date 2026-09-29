<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Support\UniqueSlug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Mengelola data kategori buku pada halaman admin.
 */
class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori beserta jumlah bukunya.
     */
    public function index(Request $request): View
    {
        $keyword = trim($request->string('search')->value());

        $categories = Category::query()
            ->withCount('books')
            ->when($keyword !== '', fn ($query) => $query->where('name', 'like', '%'.$keyword.'%'))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'keyword'));
    }

    /**
     * Menampilkan formulir penambahan kategori.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Category::create([
            'name' => $data['name'],
            // Slug dibuat otomatis dari nama kategori.
            'slug' => UniqueSlug::make($data['name'], Category::class),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir perubahan kategori.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Menyimpan perubahan data kategori.
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();

        $category->update([
            'name' => $data['name'],
            // Slug hanya dibuat ulang bila nama kategori berubah.
            'slug' => $data['name'] === $category->name
                ? $category->slug
                : UniqueSlug::make($data['name'], Category::class, $category->id),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori yang tidak lagi memiliki buku.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Kategori yang masih dipakai buku tidak boleh dihapus.
        if ($category->books()->exists()) {
            return back()->with('error', 'Kategori masih memiliki buku sehingga tidak dapat dihapus.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
