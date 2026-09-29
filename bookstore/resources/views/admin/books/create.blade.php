{{-- Formulir penambahan buku baru. --}}
@extends('layouts.admin')

@section('title', 'Tambah Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Tambah Buku</h1>
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- enctype dipakai karena formulir mengirim berkas gambar sampul. --}}
            <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
                @csrf

                @include('admin.books._form')
            </form>
        </div>
    </div>
@endsection