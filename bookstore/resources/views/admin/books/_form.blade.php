{{-- Formulir bersama untuk menambah dan mengubah data buku. --}}

<div class="row g-3">
    <div class="col-md-6">
        <label for="title" class="form-label">Judul Buku</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
               name="title" value="{{ old('title', $book->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="author" class="form-label">Nama Pengarang</label>
        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
               name="author" value="{{ old('author', $book->author ?? '') }}" required>
        @error('author')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                name="category_id" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                        @selected((int) old('category_id', $book->category_id ?? 0) === $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="publisher" class="form-label">Penerbit (opsional)</label>
        <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher"
               name="publisher" value="{{ old('publisher', $book->publisher ?? '') }}">
        @error('publisher')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="published_year" class="form-label">Tahun Terbit (opsional)</label>
        <input type="number" class="form-control @error('published_year') is-invalid @enderror"
               id="published_year" name="published_year" min="1000" max="2100"
               value="{{ old('published_year', $book->published_year ?? '') }}">
        @error('published_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="isbn" class="form-label">ISBN (opsional)</label>
        <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn"
               name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}">
        @error('isbn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <label for="price" class="form-label">Harga (Rupiah)</label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
               name="price" min="0" value="{{ old('price', $book->price ?? '') }}" required>
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock"
               name="stock" min="0" value="{{ old('stock', $book->stock ?? 0) }}" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="cover_image" class="form-label">Gambar Sampul (opsional)</label>
        <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
               id="cover_image" name="cover_image" accept="image/*">
        <div class="form-text">Format JPG, PNG, atau WEBP dengan ukuran maksimal 2 MB.</div>
        @error('cover_image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @isset($book)
            {{-- Menampilkan sampul yang sedang dipakai sebagai acuan admin. --}}
            <div class="mt-2">
                <img src="{{ $book->coverUrl() }}" alt="Sampul buku {{ $book->title }}"
                     class="border rounded" style="height: 120px;">
            </div>
        @endisset
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Deskripsi Buku</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                  name="description" rows="4">{{ old('description', $book->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>