<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi formulir perubahan data kategori.
 */
class UpdateCategoryRequest extends FormRequest
{
    /**
     * Hanya admin yang boleh mengubah kategori.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Aturan validasi data kategori. Kategori yang sedang diubah dikecualikan
     * dari pemeriksaan nama agar admin dapat menyimpan tanpa mengubah nama.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')->ignore($this->route('category')),
            ],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
