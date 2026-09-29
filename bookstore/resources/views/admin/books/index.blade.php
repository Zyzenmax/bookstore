{{-- Daftar buku pada halaman admin. --}}
@extends('layouts.admin')

@section('title', 'Kelola Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Kelola Data Buku</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Buku
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.books.index') }}" class="row g-2">
                <div class="col-md-5">
                    <label for="search" class="visually-hidden">Kata kunci</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $keyword }}" placeholder="Cari judul atau pengarang">
                </div>

                <div class="col-md-4">
                    <label for="category" class="visually-hidden">Kategori</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($categoryId === $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">Cari</button>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul dan Pengarang</th>
                        <th scope="col">Kategori</th>
                        <th scope="col" class="text-end">Harga</th>
                        <th scope="col" class="text-center">Stok</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>
                                <img src="{{ $book->coverUrl() }}" alt="Sampul buku {{ $book->title }}"
                                     class="border rounded" style="height: 60px;">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $book->title }}</div>
                                <div class="text-muted small">{{ $book->author }}</div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $book->category->name }}</span>
                            </td>
                            <td class="text-end">
                                {{ \App\Support\RupiahFormatter::format($book->price) }}
                            </td>
                            <td class="text-center">
                                @if ($book->isAvailable())
                                    {{ $book->stock }}
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.books.edit', $book) }}"
                                   class="btn btn-sm btn-outline-primary">Ubah</a>

                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus buku ini beserta sampulnya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data buku belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $books->links() }}
    </div>
@endsection