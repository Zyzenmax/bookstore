{{-- Formulir perubahan data buku. --}}
@extends('layouts.admin')

@section('title', 'Ubah Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Ubah Data Buku</h1>
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.books._form')
            </form>
        </div>
    </div>
@endsection