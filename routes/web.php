<?php

use App\Http\Controllers\AksesController;
use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KunjunganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;

// Rute untuk tampilan login
Route::get('/', [SessionController::class, 'index'])->name('login');
Route::post('/sesi/login', [SessionController::class, 'login'])->name('login.submit');

// Rute registrasi
Route::get('/register', [RegisterController::class, 'regis'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Rute yang dilindungi middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ControllerDashboard::class, 'index'])->name('dashboard');

    // Rute kunjungan
    Route::resource('kunjungan', KunjunganController::class);
    Route::get('/kunjungan-laporan', [KunjunganController::class, 'laporan'])->name('kunjungan.laporan');
    Route::get('/kunjungan-cetak', [KunjunganController::class, 'cetakLaporan'])->name('kunjungan.cetak');

    // Rute akses
    Route::resource('akses', AksesController::class);
    Route::get('/akses/{id}/password', [AksesController::class, 'getPassword'])->name('akses.password');

    // Rute masteruser
    // Rute untuk Admin
    Route::prefix('masteruser')->middleware('admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('masteruser.index');
        Route::get('/create', [UserController::class, 'create'])->name('masteruser.create');
        Route::post('/', [UserController::class, 'store'])->name('masteruser.store');
        Route::get('/data', [UserController::class, 'getData'])->name('masteruser.data');
        Route::get('/{id}', [UserController::class, 'show'])->name('masteruser.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('masteruser.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('masteruser.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('masteruser.destroy');
    });
    

    // Rute logout
    Route::post('/logout', function () {
        Log::info('Logout route accessed');
        Auth::logout();
        return redirect('/');
    })->name('logout');
});
