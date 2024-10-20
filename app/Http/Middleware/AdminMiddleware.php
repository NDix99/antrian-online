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
        // Periksa apakah pengguna sudah login dan apakah role pengguna adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Lanjutkan ke permintaan berikutnya
        }

        // Jika bukan admin, kembalikan respons forbidden atau redirect ke halaman lain
        return redirect('setting'); // Kamu bisa mengganti '/' dengan route lain yang diinginkan
    }
}
