<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pekerjaan;

class AdminWebController extends Controller
{
    public function superadminDashboard()
    {
        $user = Auth::user();

        // Jika rolenya admin_pt, arahkan ke view khusus admin PT
        if ($user->role === 'admin_pt') {
            $pendingPekerjaan = Pekerjaan::where('status_moderasi', 'menunggu')->get();
            return view('admin_pt.dashboard', compact('pendingPekerjaan'));
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
