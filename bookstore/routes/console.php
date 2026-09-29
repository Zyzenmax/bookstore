<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Perintah bawaan Laravel untuk menampilkan kutipan penyemangat.
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Menampilkan kutipan penyemangat');
