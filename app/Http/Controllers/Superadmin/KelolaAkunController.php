<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Laporan;
use Illuminate\Support\Facades\Schema;

class KelolaAkunController extends Controller
{
    private function ensureSchemaReady()
    {
        if (!Schema::hasColumn('users', 'is_suspended')) {
            Schema::table('users', function ($table) {
                $table->boolean('is_suspended')->default(false)->after('status_verifikasi_pt');
                $table->text('alasan_suspend')->nullable()->after('is_suspended');
            });
        }
    }

    public function index(Request $request)
    {
        $this->ensureSchemaReady();

        $statusFilter = $request->query('status'); // 'terverifikasi', 'menunggu', 'suspended', 'ditolak'
        $search = $request->query('search');

        $query = User::where('role', 'admin_pt')->withCount(['pekerjaans', 'laporansDiterima']);

        if ($statusFilter === 'suspended') {
            $query->where('is_suspended', true);
        } elseif ($statusFilter === 'terverifikasi') {
            $query->where('status_verifikasi_pt', 'terverifikasi')->where('is_suspended', false);
        } elseif ($statusFilter === 'menunggu') {
            $query->where('status_verifikasi_pt', 'menunggu')->where('is_suspended', false);
        } elseif ($statusFilter === 'ditolak') {
            $query->where('status_verifikasi_pt', 'ditolak');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('domisili', 'like', "%{$search}%");
            });
        }

        $mitraPTs = $query->latest()->paginate(10)->withQueryString();

        // Metrik Ringkasan Akun PT
        $totalPT = User::where('role', 'admin_pt')->count();
        $ptTerverifikasi = User::where('role', 'admin_pt')->where('status_verifikasi_pt', 'terverifikasi')->where('is_suspended', false)->count();
        $ptMenunggu = User::where('role', 'admin_pt')->where('status_verifikasi_pt', 'menunggu')->where('is_suspended', false)->count();
        $ptSuspended = User::where('role', 'admin_pt')->where('is_suspended', true)->count();
        $ptDitolak = User::where('role', 'admin_pt')->where('status_verifikasi_pt', 'ditolak')->count();

        return view('superadmin.akun.index', compact(
            'mitraPTs',
            'statusFilter',
            'search',
            'totalPT',
            'ptTerverifikasi',
            'ptMenunggu',
            'ptSuspended',
            'ptDitolak'
        ));
    }

    // Aksi Nonaktifkan / Suspend PT (Ngedownin PT Bermasalah)
    public function suspendPT(Request $request, $id)
    {
        $this->ensureSchemaReady();

        $request->validate([
            'alasan_suspend' => 'required|string|max:1000',
        ]);

        $user = User::where('role', 'admin_pt')->findOrFail($id);
        $user->is_suspended = true;
        $user->alasan_suspend = $request->alasan_suspend;
        $user->save();

        // Otomatis menonaktifkan seluruh loker aktif milik PT ini agar pencari kerja tidak tertipu
        Pekerjaan::where('user_id', $user->id)->update(['status_loker' => 'ditutup']);

        return back()->with('success', "Akun PT '{$user->name}' berhasil DINONAKTIFKAN (DISUSPEND). Semua lowongan milik PT ini telah ditutup otomatis.");
    }

    // Aksi Aktifkan Kembali Akun PT (Unsuspend)
    public function unsuspendPT($id)
    {
        $this->ensureSchemaReady();

        $user = User::where('role', 'admin_pt')->findOrFail($id);
        $user->is_suspended = false;
        $user->alasan_suspend = null;
        $user->status_verifikasi_pt = 'terverifikasi';
        $user->save();

        return back()->with('success', "Akun PT '{$user->name}' telah BERHASIL DIAKTIFKAN KEMBALI. Mitra dapat login dan membuka lowongan.");
    }

    // Update Status Verifikasi Manual
    public function updateStatusVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi_pt' => 'required|in:menunggu,terverifikasi,ditolak',
        ]);

        $user = User::where('role', 'admin_pt')->findOrFail($id);
        $user->status_verifikasi_pt = $request->status_verifikasi_pt;
        if ($request->status_verifikasi_pt === 'terverifikasi') {
            $user->is_suspended = false;
        }
        $user->save();

        return back()->with('success', "Status verifikasi akun PT '{$user->name}' berhasil diperbarui.");
    }

    // Hapus Akun PT Permanen
    public function destroy($id)
    {
        $user = User::where('role', 'admin_pt')->findOrFail($id);
        $namaPT = $user->name;
        $user->delete();

        return back()->with('success', "Akun Mitra PT '{$namaPT}' dan seluruh datanya berhasil dihapus dari sistem.");
    }
}

