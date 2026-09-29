{{-- Daftar kategori buku. --}}
@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Kelola Kategori Buku</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2">
                <div class="col-md-5">
                    <label for="search" class="visually-hidden">Kata kunci</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $keyword }}" placeholder="Cari nama kategori">
                </div>

                <div class="col-md-3 d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">Cari</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Slug</th>
                        <th scope="col" class="text-center">Jumlah Buku</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="fw-semibold">{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $category->books_count }}</span>
                            </td>
                            <td class="text-muted small">{{ $category->description ?? '-' }}</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="btn btn-sm btn-outline-primary">Ubah</a>

                                {{-- Penghapusan dikonfirmasi lebih dahulu oleh peramban. --}}
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Data kategori belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endsection