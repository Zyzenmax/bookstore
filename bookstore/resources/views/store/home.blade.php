{{-- Halaman katalog buku untuk pembeli. --}}
@extends('layouts.store')

@section('title', 'Katalog Buku')

@section('content')
    {{-- Bagian atas berisi formulir pencarian dan penyaringan kategori. --}}
    <div class="bg-white border rounded p-4 mb-4">
        <h1 class="h4 mb-1">Katalog Buku</h1>
        <p class="text-muted mb-3">Cari buku berdasarkan judul atau nama pengarang.</p>

        <form method="GET" action="{{ route('store.books.index') }}" class="row g-2">
            <div class="col-md-5">
                <label for="search" class="visually-hidden">Kata kunci pencarian</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ $keyword }}" placeholder="Contoh: Dickens">
            </div>

            <div class="col-md-4">
                <label for="category" class="visually-hidden">Kategori buku</label>
                <select class="form-select" id="category" name="category">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($categoryId === $category->id)>
                            {{ $category->name }} ({{ $category->books_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Cari</button>
                <a href="{{ route('store.books.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
            </div>
        </form>
    </div>

    <p class="text-muted small">Menampilkan {{ $books->total() }} judul buku.</p>

    <div class="row g-3">
        @forelse ($books as $book)
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $book->coverUrl() }}" class="card-img-top book-cover p-2"
                         alt="Sampul buku {{ $book->title }}">

                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-secondary align-self-start mb-2">{{ $book->category->name }}</span>
                        <h2 class="h6 mb-1">{{ $book->title }}</h2>
                        <p class="text-muted small mb-2">{{ $book->author }}</p>
                        <p class="fw-bold text-primary mb-3">
                            {{ \App\Support\RupiahFormatter::format($book->price) }}
                        </p>

                        <div class="mt-auto">
                            <p class="small mb-2">
                                @if ($book->isAvailable())
                                    <span class="text-success">Stok tersedia: {{ $book->stock }}</span>
                                @else
                                    <span class="text-danger">Stok habis</span>
                                @endif
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('store.books.show', $book) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                    Lihat Detail
                                </a>
                                @if ($book->isAvailable())
                                    <form method="POST" action="{{ route('store.cart.store', $book) }}" class="flex-fill">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-primary w-100">
                                            <i class="bi bi-cart-plus"></i> Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-sm btn-secondary flex-fill" disabled>
                                        Habis
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning mb-0">
                    Buku yang Anda cari tidak ditemukan. Silakan ubah kata kunci atau kategori.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $books->links() }}
    </div>
@endsection