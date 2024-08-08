<?php

use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/kendaraan', function () {
//     return view('welcome');
// });

// routes/web.php


Route::get('/', [SessionController::class, 'index'])->name('login');

// Rute untuk proses login
Route::post('/sesi/login', [SessionController::class, 'login'])->name('login.submit');

// Rute untuk menampilkan dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

// Rute untuk menampilkan form registrasi
Route::get('/register', [RegisterController::class, 'regis'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::middleware('auth')->post('/logout', function () {
    Log::info('Logout route accessed');
    Auth::logout();
    return redirect('/sesi'); // Pastikan ini sesuai dengan rute login Anda
})->name('logout');
Route::middleware('auth')->group(function () {
    // Rute untuk dashboard
    Route::get('/dashboard', [ControllerDashboard::class, 'index'])->name('dashboard');
});
