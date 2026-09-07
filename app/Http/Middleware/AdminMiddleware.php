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
        // Cek apakah user sudah login DAN rolenya superadmin atau admin_pt
        if (Auth::check() && in_array(Auth::user()->role, ['superadmin', 'admin_pt'])) {
            return $next($request);
        }

        // Jika bukan admin, tendang ke halaman login
        return redirect('/login')->withErrors(['email' => 'Silakan login terlebih dahulu sebagai admin.']);
    }
}
