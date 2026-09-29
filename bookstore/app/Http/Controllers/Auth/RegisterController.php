<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Menangani pendaftaran akun pembeli baru.
 */
class RegisterController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran pembeli.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menyimpan akun pembeli baru lalu langsung masuk ke halaman belanja.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Akun hasil pendaftaran selalu berperan sebagai pembeli.
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => UserRole::User,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('store.books.index')
            ->with('success', 'Akun berhasil dibuat. Selamat berbelanja!');
    }
}
