<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login admin & mitra PT
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan formulir pendaftaran akun Admin PT
     */
    public function showRegisterPtForm()
    {
        return view('auth.register_pt');
    }

    /**
     * Proses pendaftaran akun Admin PT baru (status otomatis 'menunggu' verifikasi)
     */
    public function registerPt(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'whatsapp' => 'required|string|max:20|unique:users,whatsapp',
            'domisili' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama perusahaan / PT wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar sebelumnya.',
            'whatsapp.required' => 'Nomor WhatsApp resmi wajib diisi.',
            'whatsapp.unique' => 'Nomor WhatsApp ini sudah terdaftar.',
            'domisili.required' => 'Kota atau domisili perusahaan wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'domisili' => $request->domisili,
            'password' => Hash::make($request->password),
            'role' => 'admin_pt',
            'status_verifikasi_pt' => 'menunggu', // Belum bisa login sebelum di-ACC Superadmin
        ]);

        return redirect()->route('login')->with(
            'success',
            'Pendaftaran berhasil! Akun perusahaan Anda sedang menunggu persetujuan (ACC) dari Superadmin. Anda baru dapat login setelah disetujui.'
        );
    }

    /**
     * Proses autentikasi login khusus web admin & superadmin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 1. Jika role Superadmin -> Langsung lolos ke dashboard
            if ($user->role === 'superadmin') {
                return redirect()->intended('/admin/dashboard');
            }

            // 2. Jika role Admin PT -> Cek status verifikasi Superadmin
            if ($user->role === 'admin_pt') {
                if ($user->status_verifikasi_pt === 'menunggu') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'Akun perusahaan Anda belum di-ACC oleh Superadmin (Status: Menunggu Verifikasi). Harap tunggu hingga disetujui.',
                    ]);
                }

                if ($user->status_verifikasi_pt === 'ditolak') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'Pendaftaran akun perusahaan Anda DITOLAK oleh Superadmin. Silakan hubungi admin support Luang.In.',
                    ]);
                }

                if ($user->status_verifikasi_pt === 'terverifikasi') {
                    return redirect()->intended('/admin/dashboard');
                }

                // Jika status belum terdefinisi
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Status verifikasi akun perusahaan Anda tidak valid.',
                ]);
            }

            // 3. Jika role user biasa, tolak akses web admin
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akses ditolak. Akun Anda bukan Admin atau Mitra Perusahaan.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
