<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SessionController extends Controller
{
    public function index()
    {
        return view('sesi.index');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    Log::info('Login attempt', ['email' => $request->email]);

    $user = User::where('email', $request->email)->first();

    if ($user) {
        Log::info('User found', ['user_id' => $user->id, 'email' => $user->email]);

        if ($user && Hash::check($request->password, $user->password)) {
            Log::info('Password is correct (hash)', ['user_id' => $user->id]);
            Auth::login($user);
            return redirect()->route('dashboard');
        } else {
            Log::warning('Password mismatch', ['user_id' => $user->id]);
        }
    } else {
        Log::warning('User not found', ['email' => $request->email]);
    }

    return back()->withErrors(['password' => 'Password salah atau user tidak ditemukan.']);
}
}