<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class SessionController extends Controller
{
    function index()
    {
        return view('sesi.index'); // Gunakan tanda titik untuk blade template view
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', // Tambahkan validasi email
            'password' => 'required'
        ],[
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($infologin)){
            // kalau otentifikasi sukses
            return redirect('welcome')->with('success','Berhasil Logiin');
        } else {
            // kalau otentifikasi gagal
            return redirect('sesi')->withErrors('Email dan password yang dimasukkan tidak valid');

        }
    }
}
