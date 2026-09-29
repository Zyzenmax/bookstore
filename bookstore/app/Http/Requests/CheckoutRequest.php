<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi formulir checkout pesanan buku.
 */
class CheckoutRequest extends FormRequest
{
    /**
     * Seluruh pengguna yang sudah masuk boleh melakukan checkout.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Aturan validasi data penerima pesanan.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:120'],
            // Nomor telepon hanya menerima angka, spasi, tanda hubung, dan tanda plus.
            'customer_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'note' => ['nullable', 'string', 'max:500'],
        ];
    }
}
