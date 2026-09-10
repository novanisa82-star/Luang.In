<?php

namespace App\Http\Controllers\AdminPt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PelamarController extends Controller
{
    /**
     * Tampilkan halaman Pelamar Masuk / Riwayat Pelamar
     * HANYA menampilkan lowongan dan pelamar milik PT yang sedang login.
     */
    public function index(Request $request)
    {
        $adminId = Auth::id();

        // Ambil HANYA lowongan milik PT yang sedang login
        $allLowongans = Pekerjaan::where('user_id', $adminId)->latest()->get();

        // Tentukan lowongan yang sedang dipilih
        $selectedLowonganId = $request->query('pekerjaan_id');
        $selectedLowongan = null;

        if ($selectedLowonganId) {
            // Pastikan lowongan yang dicari BENAR-BENAR milik PT ini
            $selectedLowongan = $allLowongans->firstWhere('id', $selectedLowonganId);
        }

        if (!$selectedLowongan && $allLowongans->isNotEmpty()) {
            $selectedLowongan = $allLowongans->first();
        }

        // Query pelamar: HANYA untuk lowongan yang dipilih milik PT ini
        if ($selectedLowongan) {
            $query = Application::where('pekerjaan_id', $selectedLowongan->id)->with(['user', 'pekerjaan']);

            // Filter status jika ada (menunggu, diterima, ditolak)
            $statusFilter = $request->query('status');
            if ($statusFilter && in_array($statusFilter, ['menunggu', 'diterima', 'ditolak'])) {
                $query->where('status', $statusFilter);
            }

            // Pencarian berdasarkan nama pelamar jika ada
            if ($request->filled('search')) {
                $search = $request->query('search');
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            // Hitung indikator ringkasan
            $totalPelamar = Application::where('pekerjaan_id', $selectedLowongan->id)->count();
            $diterimaCount = Application::where('pekerjaan_id', $selectedLowongan->id)
                ->where('status', 'diterima')
                ->count();
            $targetKebutuhan = 6;

            // Paginasi 4 data per halaman
            $pelamars = $query->latest()->paginate(4)->withQueryString();
        } else {
            // PT belum memiliki lowongan sama sekali
            $totalPelamar = 0;
            $diterimaCount = 0;
            $targetKebutuhan = 0;
            $statusFilter = null;
            $pelamars = new LengthAwarePaginator([], 0, 4, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        // Deteksi apakah sedang diakses dari menu Riwayat atau Pelamar
        $isRiwayat = $request->routeIs('admin_pt.riwayat*');

        return view('admin_pt.pelamar.index', compact(
            'allLowongans',
            'selectedLowongan',
            'pelamars',
            'totalPelamar',
            'diterimaCount',
            'targetKebutuhan',
            'statusFilter',
            'isRiwayat'
        ));
    }

    /**
     * Perbarui status pelamar (Terima / Tolak)
     * Memastikan pelamar yang diproses benar-benar melamar pada lowongan milik PT ini.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
        ]);

        $application = Application::whereHas('pekerjaan', function ($q) {
            $q->where('user_id', Auth::id());
        })->with(['user', 'pekerjaan'])->findOrFail($id);

        $application->status = $request->status;
        $application->save();

        if ($request->status === 'diterima') {
            $waUrl = $application->whatsapp_link;
            return back()->with([
                'success' => "Pelamar {$application->user->name} berhasil DITERIMA!",
                'open_wa' => $waUrl,
                'pelamar_diterima' => $application->user->name,
            ]);
        }

        return back()->with('success', "Status lamaran {$application->user->name} berhasil diubah menjadi DITOLAK.");
    }
}
