<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Laporan;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    private function ensureSchemaReady()
    {
        // Pastikan kolom suspension pada users sudah ada
        if (!Schema::hasColumn('users', 'is_suspended')) {
            Schema::table('users', function ($table) {
                $table->boolean('is_suspended')->default(false)->after('status_verifikasi_pt');
                $table->text('alasan_suspend')->nullable()->after('is_suspended');
            });
        }
    }

    public function index()
    {
        $this->ensureSchemaReady();

        $pendingPT = User::where('role', 'admin_pt')->where('status_verifikasi_pt', 'menunggu')->get();
        $pendingPekerjaan = Pekerjaan::where('status_moderasi', 'menunggu')->with('user')->get();
        
        $laporanPendingCount = 0;
        $totalLaporanCount = 0;
        if (Schema::hasTable('laporans')) {
            $laporanPendingCount = Laporan::where('status', 'menunggu')->count();
            $totalLaporanCount = Laporan::count();
        }

        $totalPTBermasalahCount = User::where('role', 'admin_pt')->where('is_suspended', true)->count();

        return view('superadmin.dashboard', compact(
            'pendingPT',
            'pendingPekerjaan',
            'laporanPendingCount',
            'totalLaporanCount',
            'totalPTBermasalahCount'
        ));
    }

    // Proses verifikasi akun PT baru (Terima / Tolak)
    public function prosesVerifikasiPT(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status_verifikasi_pt = $request->input('status'); // 'terverifikasi' atau 'ditolak'
        $user->save();

        return back()->with('success', "Status verifikasi PT {$user->name} berhasil diperbarui menjadi {$user->status_verifikasi_pt}.");
    }

    // Proses moderasi lowongan pekerjaan (Disetujui / Ditolak)
    public function prosesModerasiPekerjaan(Request $request, $id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->status_moderasi = $request->input('status_moderasi'); // 'disetujui' atau 'ditolak'
        $pekerjaan->save();

        return back()->with('success', "Status moderasi lowongan '{$pekerjaan->judul}' berhasil diperbarui menjadi {$pekerjaan->status_moderasi}.");
    }
}

