<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Dapatkan ID pengguna dari session atau gunakan logika sesuai kebutuhan
    $userId = auth()->user()->id; // Anda dapat menyesuaikan cara mendapatkan ID pengguna sesuai dengan autentikasi Anda

    // Periksa ID pengguna dan batasi akses jika diperlukan
    if ($userId === 1) {
        return redirect()->route('dashboard'); // Pengguna dengan ID 1 diarahkan ke halaman dashboard
    }

    return $next($request); // Izinkan pengguna dengan ID selain 1 untuk mengakses halaman selanjutnya

    }
}
