{{-- Daftar pesan dari pengguna. --}}
@extends('layouts.admin')

@section('title', 'Pesan Pengguna')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pesan Pengguna</h1>
        <span class="badge bg-warning text-dark">{{ $unreadCount }} pesan belum dibaca</span>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.messages.index') }}" class="row g-2">
                <div class="col-md-4">
                    <label for="filter" class="visually-hidden">Saringan pesan</label>
                    <select class="form-select" id="filter" name="filter">
                        <option value="">Semua pesan</option>
                        <option value="belum-dibaca" @selected($filter === 'belum-dibaca')>Belum dibaca</option>
                    </select>
                </div>

                <div class="col-md-3 d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">Saring</button>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Pengirim</th>
                        <th scope="col">Subjek</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $message->sender_name }}</div>
                                <div class="text-muted small">{{ $message->sender_email }}</div>
                            </td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->created_at->translatedFormat('d F Y, H:i') }}</td>
                            <td class="text-center">
                                @if ($message->is_read)
                                    <span class="badge bg-secondary">Sudah dibaca</span>
                                @else
                                    <span class="badge bg-warning text-dark">Baru</span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.messages.show', $message) }}"
                                   class="btn btn-sm btn-outline-primary">Baca</a>

                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus pesan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pesan dari pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $messages->links() }}
    </div>
@endsection