<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    // Trait ini menyediakan method authorize() untuk memeriksa hak akses.
    use AuthorizesRequests;
}
