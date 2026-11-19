<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan masuk terlebih dahulu.']);
        }

        $user = Auth::user();

        // Jika minta role 'pegawai', cek apakah user adalah salah satu aparat kelurahan
        if (in_array('pegawai', $roles) && $user->isPegawai()) {
            return $next($request);
        }

        // Cek apakah role user ada di dalam daftar roles
        if (in_array($user->role, $roles) || $user->isAdmin()) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda tidak memiliki wewenang untuk membuka halaman ini.');
    }
}
