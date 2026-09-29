<?php

/*
|--------------------------------------------------------------------------
| Pesan Validasi
|--------------------------------------------------------------------------
|
| Berkas ini memuat pesan kesalahan validasi dalam bahasa Indonesia agar
| pengguna memahami kesalahan pengisian formulir dengan mudah.
|
*/

return [

    'required' => 'Kolom :attribute wajib diisi.',
    'string' => 'Kolom :attribute harus berupa teks.',
    'integer' => 'Kolom :attribute harus berupa angka bulat.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'boolean' => 'Kolom :attribute harus bernilai ya atau tidak.',
    'email' => 'Format :attribute tidak valid.',
    'image' => 'Kolom :attribute harus berupa berkas gambar.',
    'mimes' => 'Kolom :attribute harus berformat :values.',
    'in' => 'Pilihan :attribute tidak valid.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'unique' => ':attribute sudah dipakai, silakan gunakan yang lain.',
    'exists' => ':attribute yang dipilih tidak ditemukan.',
    'regex' => 'Format :attribute tidak sesuai.',

    'max' => [
        'string' => 'Kolom :attribute maksimal :max karakter.',
        'file' => 'Ukuran :attribute maksimal :max kilobita.',
        'numeric' => 'Nilai :attribute maksimal :max.',
    ],

    'min' => [
        'string' => 'Kolom :attribute minimal :min karakter.',
        'file' => 'Ukuran :attribute minimal :min kilobita.',
        'numeric' => 'Nilai :attribute minimal :min.',
        'array' => 'Kolom :attribute minimal berisi :min item.',
    ],

    'digits_between' => 'Kolom :attribute harus terdiri dari :min sampai :max angka.',
    'gte' => ['numeric' => 'Nilai :attribute minimal :value.'],
    'lte' => ['numeric' => 'Nilai :attribute maksimal :value.'],

    /*
    |--------------------------------------------------------------------------
    | Nama Kolom
    |--------------------------------------------------------------------------
    |
    | Bagian ini mengganti nama kolom formulir menjadi sebutan yang mudah
    | dipahami pengguna pada pesan kesalahan validasi.
    |
    */

    'attributes' => [
        'name' => 'nama',
        'email' => 'alamat email',
        'password' => 'kata sandi',
        'phone' => 'nomor telepon',
        'category_id' => 'kategori',
        'title' => 'judul buku',
        'author' => 'nama pengarang',
        'publisher' => 'penerbit',
        'published_year' => 'tahun terbit',
        'isbn' => 'ISBN',
        'price' => 'harga',
        'stock' => 'stok',
        'description' => 'keterangan',
        'cover_image' => 'gambar sampul',
        'customer_name' => 'nama penerima',
        'customer_phone' => 'nomor telepon penerima',
        'shipping_address' => 'alamat pengiriman',
        'note' => 'catatan',
        'sender_name' => 'nama pengirim',
        'sender_email' => 'alamat email pengirim',
        'subject' => 'subjek pesan',
        'message' => 'isi pesan',
        'quantity' => 'jumlah',
    ],

];
