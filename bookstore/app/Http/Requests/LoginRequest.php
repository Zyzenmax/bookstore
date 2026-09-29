<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi formulir masuk untuk admin maupun pembeli.
 */
class LoginRequest extends FormRequest
{
    /**
     * Semua pengunjung boleh mencoba masuk melalui formulir ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi data masuk.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:180'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
