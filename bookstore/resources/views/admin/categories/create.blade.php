{{-- Formulir penambahan kategori baru. --}}
@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Tambah Kategori</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                @include('admin.categories._form')
            </form>
        </div>
    </div>
@endsection