<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Application;

class AdminWebController extends Controller
{
    public function superadminDashboard()
    {
        $user = Auth::user();

        // Jika rolenya admin_pt, arahkan ke view khusus admin PT dengan data real
        if ($user->role === 'admin_pt') {
            $lowonganAktifCount = Pekerjaan::where('user_id', $user->id)->where('status_loker', 'aktif')->count();
            $pelamarMasukCount = Application::whereHas('pekerjaan', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();
            $kandidatDiterimaCount = Application::whereHas('pekerjaan', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'diterima')->count();
            $recentPekerjaan = Pekerjaan::where('user_id', $user->id)->latest()->take(5)->get();

            return view('admin_pt.dashboard', compact(
                'lowonganAktifCount',
                'pelamarMasukCount',
                'kandidatDiterimaCount',
                'recentPekerjaan'
            ));
        }

        // Jika rolenya superadmin, tampilkan panel lengkap superadmin
        $pendingPT = User::where('role', 'admin_pt')->where('status_verifikasi_pt', 'menunggu')->get();
        $pendingPekerjaan = Pekerjaan::where('status_moderasi', 'menunggu')->get();

        return view('superadmin.dashboard', compact('pendingPT', 'pendingPekerjaan'));
    }

    // Proses verifikasi akun PT (Terima / Tolak)
    public function prosesVerifikasiPT(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status_verifikasi_pt = $request->input('status'); // 'terverifikasi' atau 'ditolak'
        $user->save();

        return back()->with('success', 'Status verifikasi PT berhasil diperbarui.');
    }

    // Proses moderasi lowongan pekerjaan (Disetujui / Ditolak)
    public function prosesModerasiPekerjaan(Request $request, $id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->status_moderasi = $request->input('status_moderasi'); // 'disetujui' atau 'ditolak'
        $pekerjaan->save();

        return back()->with('success', 'Status moderasi pekerjaan berhasil diperbarui.');
    }
}

