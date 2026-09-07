<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses autentikasi login khusus web admin & superadmin
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Pengecekan role: Hanya boleh masuk jika rolenya superadmin atau admin_pt
            if ($user->role === 'superadmin' || $user->role === 'admin_pt') {
                return redirect()->intended('/admin/dashboard');
            }

            // Jika role user biasa, langsung logout dan tolak akses
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akses ditolak. Akun Anda bukan Admin.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
