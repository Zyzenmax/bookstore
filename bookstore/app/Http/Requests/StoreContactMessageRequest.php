<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi formulir pesan kepada admin.
 */
class StoreContactMessageRequest extends FormRequest
{
    /**
     * Seluruh pengguna yang sudah masuk boleh mengirim pesan.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Aturan validasi data pesan.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sender_name' => ['required', 'string', 'max:120'],
            'sender_email' => ['required', 'string', 'email', 'max:180'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:2000'],
        ];
    }
}
