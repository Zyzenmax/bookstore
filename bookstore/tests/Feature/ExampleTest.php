<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Halaman utama diarahkan ke halaman login karena aplikasi
     * tidak memiliki halaman pendarat.
     */
    public function test_halaman_utama_mengarah_ke_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }
}
