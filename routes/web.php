<?php

use App\Http\Controllers\AksesController;
use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\KunjunganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;

// Rute untuk tampilan login
Route::get('/', [SessionController::class, 'index'])->name('login');
Route::post('/sesi/login', [SessionController::class, 'login'])->name('login.submit');

// Rute yang dilindungi middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ControllerDashboard::class, 'index'])->name('dashboard');

    // Rute kunjungan
    Route::resource('kunjungan', KunjunganController::class);
    // Rute cetak laporan Kunjungan
    Route::get('/kunjungan-laporan', [KunjunganController::class, 'laporan'])->name('kunjungan.laporan');
    Route::get('/kunjungan-cetak', [KunjunganController::class, 'cetakLaporan'])->name('kunjungan.cetak');

    // Rute akses
    Route::resource('akses', AksesController::class);
    Route::get('/akses/{id}/password', [AksesController::class, 'getPassword'])->name('akses.password');

    Route::middleware(['admin'])->group(function () {
        Route::prefix('masteruser')->name('masteruser.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/users/data', [UserController::class, 'getData'])->name('getData');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/create', [UserController::class, 'store'])->name('store'); // Rute untuk menyimpan user baru
        });
    });
    


    // Rute logout
    Route::post('/logout', function () {
        Log::info('Logout route accessed');
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

