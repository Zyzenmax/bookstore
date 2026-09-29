<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Menangani proses masuk pengguna, baik admin maupun pembeli.
 */
class LoginController extends Controller
{
    /**
     * Menampilkan satu halaman login untuk seluruh pengguna.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Memeriksa data login lalu mengarahkan pengguna sesuai perannya.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        // Autentikasi memakai guard web bawaan Laravel.
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau kata sandi tidak sesuai.']);
        }

        // Sesi diperbarui agar terhindar dari pencurian sesi lama.
        $request->session()->regenerate();

        return redirect()->intended($this->homePageFor($request));
    }

    /**
     * Mengakhiri sesi pengguna lalu kembali ke halaman login.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('store.books.index')->with('status', 'Anda telah keluar dari aplikasi.');
    }

    /**
     * Menentukan halaman tujuan setelah login berhasil.
     */
    private function homePageFor(Request $request): string
    {
        // Admin masuk ke dasbor, pembeli langsung ke halaman belanja buku.
        return $request->user()->isAdmin()
            ? route('admin.dashboard')
            : route('store.books.index');
    }
}
