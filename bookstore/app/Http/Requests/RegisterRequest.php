<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi formulir pendaftaran akun pembeli baru.
 */
class RegisterRequest extends FormRequest
{
    /**
     * Pendaftaran terbuka untuk semua pengunjung.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi data pendaftaran.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:180', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            // Kata sandi harus diketik dua kali agar tidak salah isi.
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
