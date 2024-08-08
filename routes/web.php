<?php

use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Rute untuk tampilan login
Route::get('/', [SessionController::class, 'index'])->name('login');

// Rute untuk proses login
Route::post('/sesi/login', [SessionController::class, 'login'])->name('login.submit');



// Rute untuk menampilkan form registrasi
Route::get('/register', [RegisterController::class, 'regis'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Rute untuk logout
Route::middleware('auth')->post('/logout', function () {
    Log::info('Logout route accessed');
    Auth::logout();
    return redirect('/'); // Pastikan ini sesuai dengan rute login Anda
})->name('logout');

// Rute untuk dashboard (dilindungi oleh middleware auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ControllerDashboard::class, 'index'])->name('dashboard');
});