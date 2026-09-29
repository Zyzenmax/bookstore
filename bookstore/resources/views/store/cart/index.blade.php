{{-- Halaman keranjang belanja pembeli. --}}
@extends('layouts.store')

@section('title', 'Keranjang Belanja')

@section('content')
    <h1 class="h4 mb-3">Keranjang Belanja</h1>

    @if ($cartItems->isEmpty())
        <div class="alert alert-info">Keranjang belanja Anda masih kosong.</div>
        <a href="{{ route('store.books.index') }}" class="btn btn-primary">Lihat Katalog Buku</a>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Buku</th>
                            <th scope="col" class="text-end">Harga</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-end">Subtotal</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $cartItem)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $cartItem->book->coverUrl() }}" width="48" height="64"
                                             alt="Sampul buku {{ $cartItem->book->title }}" class="border rounded">

                                        <div>
                                            <a href="{{ route('store.books.show', $cartItem->book) }}"
                                               class="fw-semibold text-decoration-none">
                                                {{ $cartItem->book->title }}
                                            </a>
                                            <div class="text-muted small">{{ $cartItem->book->author }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-end">
                                    {{ \App\Support\RupiahFormatter::format($cartItem->book->price) }}
                                </td>

                                <td class="text-center">
                                    {{-- Formulir untuk mengubah jumlah buku. --}}
                                    <form method="POST" action="{{ route('store.cart.update', $cartItem) }}"
                                          class="d-flex justify-content-center gap-1">
                                        @csrf
                                        @method('PATCH')

                                        <input type="number" class="form-control form-control-sm" name="quantity"
                                               value="{{ $cartItem->quantity }}" min="1"
                                               max="{{ $cartItem->book->stock }}" style="width: 80px;"
                                               aria-label="Jumlah buku">

                                        <button type="submit" class="btn btn-sm btn-outline-primary">Ubah</button>
                                    </form>
                                </td>

                                <td class="text-end">
                                    {{ \App\Support\RupiahFormatter::format($cartItem->subtotal()) }}
                                </td>

                                <td class="text-center">
                                    {{-- Formulir untuk menghapus buku dari keranjang. --}}
                                    <form method="POST" action="{{ route('store.cart.destroy', $cartItem) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Total Harga</th>
                            <th class="text-end">
                                {{ \App\Support\RupiahFormatter::format($totalPrice) }}
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('store.books.index') }}" class="btn btn-outline-secondary">Lanjut Belanja</a>
            <a href="{{ route('store.checkout.index') }}" class="btn btn-primary">Lanjut ke Checkout</a>
        </div>
    @endif
@endsection