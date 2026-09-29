<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi formulir penambahan buku baru.
 */
class StoreBookRequest extends FormRequest
{
    /**
     * Hanya admin yang boleh menambah buku.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Aturan validasi data buku.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:180'],
            'author' => ['required', 'string', 'max:120'],
            'publisher' => ['nullable', 'string', 'max:120'],
            'published_year' => ['nullable', 'integer', 'min:1000', 'max:2100'],
            'isbn' => ['nullable', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0', 'max:100000000'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'description' => ['nullable', 'string', 'max:2000'],
            // Gambar sampul bersifat opsional dengan ukuran maksimal dua megabita.
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
