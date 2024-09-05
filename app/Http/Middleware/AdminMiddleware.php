<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    // Memeriksa apakah pengguna sudah login dan memiliki peran admin
    if (Auth::check() && Auth::user()->is_admin) {
        \Log::info('AdminMiddleware passed: User is admin.');
        return $next($request);
    }

    \Log::warning('AdminMiddleware failed: User is not admin.');
    // Redirect jika bukan admin
    return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
}
}