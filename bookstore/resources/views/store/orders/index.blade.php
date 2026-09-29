{{-- Halaman riwayat pesanan milik pembeli. --}}
@extends('layouts.store')

@section('title', 'Pesanan Saya')

@section('content')
    <h1 class="h4 mb-3">Pesanan Saya</h1>

    @if ($orders->isEmpty())
        <div class="alert alert-info">Anda belum memiliki pesanan.</div>
        <a href="{{ route('store.books.index') }}" class="btn btn-primary">Mulai Belanja</a>
    @else
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Nomor Pesanan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col" class="text-center">Jumlah Buku</th>
                            <th scope="col" class="text-end">Total</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->translatedFormat('d F Y, H:i') }}</td>
                                <td class="text-center">{{ $order->items_count }}</td>
                                <td class="text-end">
                                    {{ \App\Support\RupiahFormatter::format($order->total_price) }}
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $order->status->badgeClass() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('store.orders.show', $order) }}"
                                       class="btn btn-sm btn-outline-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    @endif
@endsection