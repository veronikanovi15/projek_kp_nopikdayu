<?php

use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KunjunganController;
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


//https://chatgpt.com/share/f6ecdbff-4478-4627-b578-2535c39fc8f6

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

//route kunjungan
Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
Route::get('/kunjungan-add', [KunjunganController::class, 'create'])->name('kunjungan.create');
Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/kunjungan/{id}/edit',[KunjunganController::class, 'edit'])->name('kunjungan.edit');

// Route untuk memperbarui data kunjungan
Route::put('/kunjungan/{id}', [KunjunganController::class, 'update'])->name('kunjungan.update');
// Route untuk menghapus data kunjungan
Route::delete('/kunjungan/{id}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');