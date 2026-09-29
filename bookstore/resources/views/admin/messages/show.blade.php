{{-- Isi satu pesan dari pengguna. --}}
@extends('layouts.admin')

@section('title', 'Isi Pesan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Isi Pesan</h1>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h2 class="h5 mb-1">{{ $message->subject }}</h2>
            <p class="text-muted small mb-0">
                Dari {{ $message->sender_name }} ({{ $message->sender_email }})
                pada {{ $message->created_at->translatedFormat('d F Y, H:i') }} WIB
            </p>
        </div>

        <div class="card-body">
            {{-- nl2br menjaga baris baru pada isi pesan tetap terbaca. --}}
            <p class="mb-0">{!! nl2br(e($message->message)) !!}</p>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <span class="text-muted small">
                @if ($message->user !== null)
                    Dikirim oleh akun: {{ $message->user->name }}
                @else
                    Pengirim sudah tidak memiliki akun.
                @endif
            </span>

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                  onsubmit="return confirm('Hapus pesan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus Pesan</button>
            </form>
        </div>
    </div>
@endsection