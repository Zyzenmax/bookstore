{{-- Halaman rincian sebuah buku. --}}
@extends('layouts.store')

@section('title', $book->title)

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('store.books.index') }}">Katalog</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('store.books.index', ['category' => $book->category_id]) }}">
                    {{ $book->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <img src="{{ $book->coverUrl() }}" class="img-fluid book-cover-detail"
                         alt="Sampul buku {{ $book->title }}">
                </div>

                <div class="col-md-8">
                    <span class="badge bg-secondary mb-2">{{ $book->category->name }}</span>
                    <h1 class="h4">{{ $book->title }}</h1>
                    <p class="text-muted mb-2">Pengarang: {{ $book->author }}</p>
                    <p class="h4 text-primary">
                        {{ \App\Support\RupiahFormatter::format($book->price) }}
                    </p>

                    <table class="table table-sm w-auto">
                        <tbody>
                            <tr>
                                <th scope="row">Penerbit</th>
                                <td>{{ $book->publisher ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tahun Terbit</th>
                                <td>{{ $book->published_year ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ISBN</th>
                                <td>{{ $book->isbn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Stok</th>
                                <td>{{ $book->stock }} buku</td>
                            </tr>
                        </tbody>
                    </table>

                    @if ($book->isAvailable())
                        {{-- Formulir penambahan buku ke keranjang belanja. --}}
                        <form method="POST" action="{{ route('store.cart.store', $book) }}"
                              class="row g-2 align-items-end">
                            @csrf

                            <div class="col-4 col-md-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                       value="1" min="1" max="{{ $book->stock }}">
                            </div>

                            <div class="col-8 col-md-5 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning mb-0">Stok buku ini sedang habis.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Deskripsi Buku</div>
        <div class="card-body">
            <p class="mb-0">{{ $book->description ?? 'Belum ada deskripsi untuk buku ini.' }}</p>
        </div>
    </div>

    @if ($relatedBooks->isNotEmpty())
        <h2 class="h5 mb-3">Buku Lain pada Kategori Ini</h2>

        <div class="row g-3">
            @foreach ($relatedBooks as $relatedBook)
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $relatedBook->coverUrl() }}" class="card-img-top book-cover p-2"
                             alt="Sampul buku {{ $relatedBook->title }}">

                        <div class="card-body d-flex flex-column">
                            <h3 class="h6 mb-1">{{ $relatedBook->title }}</h3>
                            <p class="text-muted small mb-2">{{ $relatedBook->author }}</p>
                            <p class="fw-bold text-primary mb-3">
                                {{ \App\Support\RupiahFormatter::format($relatedBook->price) }}
                            </p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('store.books.show', $relatedBook) }}"
                               class="btn btn-sm btn-outline-primary flex-fill">Lihat Detail</a>
                            @if ($relatedBook->isAvailable())
                                <form method="POST" action="{{ route('store.cart.store', $relatedBook) }}" class="flex-fill">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                        <i class="bi bi-cart-plus"></i> Keranjang
                                    </button>
                                </form>
                            @endif
                        </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection