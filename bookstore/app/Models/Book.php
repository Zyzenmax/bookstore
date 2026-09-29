<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Data buku yang dijual pada toko buku ini.
 */
#[Fillable([
    'category_id', 'title', 'slug', 'author', 'publisher',
    'published_year', 'isbn', 'price', 'stock', 'description', 'cover_image',
])]
class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory;

    /** Nama berkas gambar sampul bawaan pada folder public/images/books. */
    public const DEFAULT_COVER = 'sampul-bawaan.svg';

    /**
     * Menentukan tipe data kolom yang perlu dikonversi otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock' => 'integer',
            'published_year' => 'integer',
        ];
    }

    /**
     * Relasi buku ke kategorinya.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi buku ke baris keranjang belanja yang memuat buku ini.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relasi buku ke rincian pesanan yang memuat buku ini.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Memakai slug sebagai kunci rute agar alamat halaman mudah dibaca.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Alamat gambar sampul buku. Gambar bawaan dipakai bila sampul belum diunggah.
     */
    public function coverUrl(): string
    {
        $fileName = $this->cover_image ?? self::DEFAULT_COVER;

        return asset('images/books/'.$fileName);
    }

    /**
     * Memeriksa apakah stok buku masih tersedia.
     */
    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Menyaring daftar buku berdasarkan kata kunci judul atau nama pengarang.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        // Kata kunci kosong berarti seluruh buku tetap ditampilkan.
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($keyword): void {
            $query->where('title', 'like', '%'.$keyword.'%')
                ->orWhere('author', 'like', '%'.$keyword.'%');
        });
    }

    /**
     * Menyaring daftar buku pada satu kategori tertentu.
     */
    public function scopeInCategory(Builder $query, ?int $categoryId): Builder
    {
        if (blank($categoryId)) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }
}
