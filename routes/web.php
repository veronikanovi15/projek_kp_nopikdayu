

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

    // Route untuk Kunjungan
    Route::prefix('kunjungan')->group(function () {
        Route::get('/', [KunjunganController::class, 'index'])->name('kunjungan.index');
        Route::get('/add', [KunjunganController::class, 'create'])->name('kunjungan.create');
        Route::post('/', [KunjunganController::class, 'store'])->name('kunjungan.store');
        Route::get('/{id}/edit', [KunjunganController::class, 'edit'])->name('kunjungan.edit');
        Route::put('/{id}', [KunjunganController::class, 'update'])->name('kunjungan.update');
        Route::delete('/{id}', [KunjunganController::class, 'destroy'])->name('kunjungan.destroy');
        Route::get('/{id}', [KunjunganController::class, 'show'])->name('kunjungan.show');
        Route::get('/laporan', [KunjunganController::class, 'laporan'])->name('kunjungan.laporan');
        Route::get('/cetak', [KunjunganController::class, 'cetakLaporan'])->name('kunjungan.cetak');
    });

    // Route untuk Akses
    Route::prefix('akses')->group(function () {
        Route::get('/', [AksesController::class, 'index'])->name('akses.index');
        Route::get('/create', [AksesController::class, 'create'])->name('akses.create');
        Route::post('/', [AksesController::class, 'store'])->name('akses.store');
        Route::get('/{id}/password', [AksesController::class, 'getPassword'])->name('akses.password');
        // routes/web.php
Route::resource('akses', AksesController::class);

    });

    // Route untuk Master User
    Route::prefix('masteruser')->middleware('admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('masteruser.index');
        Route::get('/create', [UserController::class, 'create'])->name('masteruser.create');
        Route::post('/', [UserController::class, 'store'])->name('masteruser.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('masteruser.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('masteruser.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('masteruser.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('masteruser.destroy');
        Route::get('/masteruser/data', [UserController::class, 'getData'])->name('masteruser.data');
     

    });
});
