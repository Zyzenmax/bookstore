<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menampilkan halaman kontak admin.
 */
class PageController extends Controller
{
    /**
     * Menampilkan halaman Tentang Kami.
     */
    public function about(Request $request): View
    {
        return view('store.pages.about');
    }

    /**
     * Menampilkan formulir kontak admin.
     */
    public function contact(Request $request): View
    {
        return view('store.pages.contact', ['user' => $request->user()]);
    }

    /**
     * Menyimpan pesan pengguna untuk admin.
     */
    public function sendMessage(StoreContactMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        ContactMessage::create([
            'user_id' => $request->user()->id,
            'sender_name' => $data['sender_name'],
            'sender_email' => $data['sender_email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        return redirect()
            ->route('store.pages.contact')
            ->with('success', 'Pesan berhasil dikirim. Admin akan membalas melalui email Anda.');
    }
}
