<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya pengguna yang terautentikasi yang dapat mengakses metode ini
    }

    // Metode untuk menampilkan halaman dashboard
    public function index()
    {
        return view('dashboard'); // Nama view dashboard
    }
}
