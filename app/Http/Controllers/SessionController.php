<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    function index()
    {
        return view('sesi.index');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ],[
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'g-recaptcha-response.required' => 'Pastikan Anda bukan robot'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infologin)) {
            // kalau otentifikasi sukses
            return redirect('dashboard')->with('success', 'Berhasil Login');
        } else {
            // kalau otentifikasi gagal
            // Cek apakah email terdaftar
            $user = \App\Models\User::where('email', $request->email)->first();
            if ($user) {
                // Email ada, berarti kemungkinan password salah
                return redirect('')->withErrors(['password' => 'Password yang dimasukkan tidak valid']);
            } else {
                // Email tidak ada
                return redirect('')->withErrors(['email' => 'Email tidak terdaftar']);
            }
            
        }

}
}
