<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     * Hanya memperbolehkan Superadmin untuk memproses verifikasi PT dan moderasi pekerjaan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors([
                'email' => 'Silakan login terlebih dahulu.',
            ]);
        }

        $user = Auth::user();

        if ($user->role !== 'superadmin') {
            return redirect()->route('admin_pt.dashboard')->with('error', 'Akses ditolak. Fitur ini khusus untuk Superadmin.');
        }

        return $next($request);
    }
}

