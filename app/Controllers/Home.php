<?php

namespace App\Controllers;

// Controller default CodeIgniter, menampilkan halaman welcome bawaan framework
class Home extends BaseController
{
    // Menampilkan halaman utama default (welcome_message)
    public function index(): string
    {
        return view('welcome_message');
    }
}
