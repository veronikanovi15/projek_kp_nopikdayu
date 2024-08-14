<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aksess;
use App\Models\MKunjungan;

class ControllerDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan hanya pengguna yang terautentikasi yang dapat mengakses metode ini
    }

    // Metode untuk menampilkan halaman dashboard
    public function index()
    {
        $aksesCount = Aksess::count(); // Menghitung jumlah data di tabel Akses
        $kunjunganCount = MKunjungan::count(); // Menghitung jumlah data di tabel Kunjungan

        return view('dashboard', [
            'aksesCount' => $aksesCount,
            'kunjunganCount' => $kunjunganCount
        ]);
    }
}
