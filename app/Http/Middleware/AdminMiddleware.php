<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Superadmin selalu memiliki akses penuh
            if ($user->role === 'superadmin') {
                return $next($request);
            }

            // Admin PT harus sudah diverifikasi dan tidak dalam status dinonaktifkan (suspend)
            if ($user->role === 'admin_pt') {
                if ($user->is_suspended) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect('/login')->withErrors([
                        'email' => 'Akun perusahaan Anda sedang dinonaktifkan (disuspend) oleh Superadmin. Alasan: ' . ($user->alasan_suspend ?: 'Pelanggaran ketentuan operasional.'),
                    ]);
                }

                if ($user->status_verifikasi_pt === 'terverifikasi') {
                    return $next($request);
                }

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors([
                    'email' => 'Akun perusahaan Anda belum di-ACC oleh Superadmin. Silakan tunggu hingga disetujui.',
                ]);
            }
        }

        // Jika belum login atau bukan admin, tendang ke halaman login
        return redirect('/login')->withErrors([
            'email' => 'Silakan login terlebih dahulu untuk mengakses halaman admin.',
        ]);
    }
}
