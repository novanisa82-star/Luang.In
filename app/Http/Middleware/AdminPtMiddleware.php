<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminPtMiddleware
{
    /**
     * Handle an incoming request.
     * Hanya memperbolehkan Admin PT yang telah terverifikasi untuk mengelola lowongan & pelamar.
     * Superadmin dicegah membuka/mengelola lowongan dan diarahkan kembali ke panel moderasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors([
                'email' => 'Silakan login terlebih dahulu.',
            ]);
        }

        $user = Auth::user();

        // Superadmin tidak memiliki fitur membuka atau mengelola lowongan PT
        if ($user->role === 'superadmin') {
            return redirect()->route('admin_pt.dashboard')->with('error', 'Superadmin tidak memiliki akses untuk membuat atau mengelola lowongan pekerjaan. Panel Superadmin dikhususkan untuk moderasi lowongan dan verifikasi akun mitra PT.');
        }

        // Pastikan hanya role admin_pt yang sudah terverifikasi dan tidak disuspend
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
                'email' => 'Akun perusahaan Anda belum di-ACC oleh Superadmin.',
            ]);
        }

        return redirect('/login')->withErrors([
            'email' => 'Akses ditolak. Fitur ini hanya diperuntukkan bagi Mitra Perusahaan (Admin PT).',
        ]);
    }
}

