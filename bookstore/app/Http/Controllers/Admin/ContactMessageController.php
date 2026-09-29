<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Membaca pesan yang dikirim pengguna melalui halaman kontak.
 */
class ContactMessageController extends Controller
{
    /**
     * Menampilkan daftar pesan pengguna.
     */
    public function index(Request $request): View
    {
        $filter = $request->string('filter')->value();

        $messages = ContactMessage::query()
            ->with('user')
            ->when($filter === 'belum-dibaca', fn ($query) => $query->unread())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Jumlah pesan belum dibaca dipakai pada badge menu pesan.
        $unreadCount = ContactMessage::query()->unread()->count();

        return view('admin.messages.index', compact('messages', 'filter', 'unreadCount'));
    }

    /**
     * Menampilkan isi satu pesan dan menandainya sudah dibaca.
     */
    public function show(ContactMessage $message): View
    {
        // Pesan yang sudah dibuka admin otomatis ditandai sudah dibaca.
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Menghapus pesan pengguna.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
