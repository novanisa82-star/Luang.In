<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Application;
use Illuminate\Support\Facades\Schema;

class LaporanController extends Controller
{
    private function ensureLaporanTableExists()
    {
        if (!Schema::hasTable('laporans')) {
            Schema::create('laporans', function ($table) {
                $table->id();
                $table->foreignId('pelapor_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('nama_pelapor')->nullable();
                $table->string('kontak_pelapor')->nullable();
                $table->foreignId('terlapor_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('pekerjaan_id')->nullable()->constrained('pekerjaans')->nullOnDelete();
                $table->string('kategori')->default('lainnya');
                $table->string('judul');
                $table->text('deskripsi');
                $table->string('bukti_lampiran')->nullable();
                $table->enum('status', ['menunggu', 'proses', 'selesai', 'ditolak'])->default('menunggu');
                $table->text('tindakan_superadmin')->nullable();
                $table->timestamps();
            });

            // Sample data awal
            $ptSample = User::where('role', 'admin_pt')->first();
            $jobSample = Pekerjaan::first();
            $userSample = User::where('role', 'user')->first();

            Laporan::create([
                'pelapor_id' => $userSample ? $userSample->id : null,
                'nama_pelapor' => $userSample ? $userSample->name : 'Budi Santoso (Pekerja Lapangan)',
                'kontak_pelapor' => '081234567890',
                'terlapor_id' => $ptSample ? $ptSample->id : null,
                'pekerjaan_id' => $jobSample ? $jobSample->id : null,
                'kategori' => 'upah_tidak_sesuai',
                'judul' => 'Upah yang dibayarkan tidak sesuai dengan nominal yang tertera di lowongan',
                'deskripsi' => 'Pada deskripsi lowongan tertulis Rp 150.000 per shift, namun saat pekerjaan selesai diberikan Rp 100.000 tanpa penjelasan jelas.',
                'status' => 'menunggu',
            ]);

            Laporan::create([
                'pelapor_id' => null,
                'nama_pelapor' => 'Ahmad Fauzi (Pelamar)',
                'kontak_pelapor' => '085712348899',
                'terlapor_id' => $ptSample ? $ptSample->id : null,
                'pekerjaan_id' => $jobSample ? $jobSample->id : null,
                'kategori' => 'kontak_palsu',
                'judul' => 'Nomor WhatsApp kontak PIC lowongan tidak dapat dihubungi',
                'deskripsi' => 'Nomor PIC yang tertera di lowongan tidak aktif dan tidak membalas konfirmasi jadwal kerja di lokasi kerja.',
                'status' => 'proses',
                'tindakan_superadmin' => 'Pemberitahuan SP1 ke Mitra PT: Segera update nomor PIC aktif dalam 24 jam.',
            ]);
        }
    }

    public function index(Request $request)
    {
        $this->ensureLaporanTableExists();

        $tab = $request->query('tab', 'pengaduan'); // 'pengaduan' atau 'rekap'
        $statusFilter = $request->query('status');
        $kategoriFilter = $request->query('kategori');
        $search = $request->query('search');

        // Query Laporan Pengaduan
        $query = Laporan::with(['pelapor', 'terlapor', 'pekerjaan']);

        if ($statusFilter && in_array($statusFilter, ['menunggu', 'proses', 'selesai', 'ditolak'])) {
            $query->where('status', $statusFilter);
        }

        if ($kategoriFilter) {
            $query->where('kategori', $kategoriFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('nama_pelapor', 'like', "%{$search}%");
            });
        }

        $laporans = $query->latest()->paginate(10)->withQueryString();

        // Statistik Pengaduan
        $totalLaporan = Laporan::count();
        $laporanMenunggu = Laporan::where('status', 'menunggu')->count();
        $laporanProses = Laporan::where('status', 'proses')->count();
        $laporanSelesai = Laporan::where('status', 'selesai')->count();
        $laporanDitolak = Laporan::where('status', 'ditolak')->count();

        // Statistik Rekapitulasi Platform
        $totalPT = User::where('role', 'admin_pt')->count();
        $ptTerverifikasi = User::where('role', 'admin_pt')->where('status_verifikasi_pt', 'terverifikasi')->count();
        $totalLoker = Pekerjaan::count();
        $lokerDisetujui = Pekerjaan::where('status_moderasi', 'disetujui')->count();
        $totalPelamar = Application::count();
        $pelamarDiterima = Application::where('status', 'diterima')->count();

        // Daftar PT & Loker untuk dropdown buat laporan baru manual
        $listPT = User::where('role', 'admin_pt')->get();
        $listLoker = Pekerjaan::latest()->take(30)->get();

        return view('superadmin.laporan.index', compact(
            'laporans',
            'tab',
            'statusFilter',
            'kategoriFilter',
            'search',
            'totalLaporan',
            'laporanMenunggu',
            'laporanProses',
            'laporanSelesai',
            'laporanDitolak',
            'totalPT',
            'ptTerverifikasi',
            'totalLoker',
            'lokerDisetujui',
            'totalPelamar',
            'pelamarDiterima',
            'listPT',
            'listLoker'
        ));
    }

    public function store(Request $request)
    {
        $this->ensureLaporanTableExists();

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'nama_pelapor' => 'nullable|string|max:255',
            'kontak_pelapor' => 'nullable|string|max:100',
            'terlapor_id' => 'nullable|exists:users,id',
            'pekerjaan_id' => 'nullable|exists:pekerjaans,id',
        ]);

        Laporan::create([
            'pelapor_id' => Auth::id(),
            'nama_pelapor' => $request->nama_pelapor ?: Auth::user()->name,
            'kontak_pelapor' => $request->kontak_pelapor ?: Auth::user()->whatsapp,
            'terlapor_id' => $request->terlapor_id,
            'pekerjaan_id' => $request->pekerjaan_id,
            'kategori' => $request->kategori,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 'menunggu',
        ]);

        return redirect()->route('superadmin.laporan.index')->with('success', 'Laporan pengaduan berhasil dicatat.');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->ensureLaporanTableExists();

        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,ditolak',
            'tindakan_superadmin' => 'nullable|string',
            'suspend_terlapor' => 'nullable|boolean',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->status = $request->status;
        if ($request->filled('tindakan_superadmin')) {
            $laporan->tindakan_superadmin = $request->tindakan_superadmin;
        }
        $laporan->save();

        // Opsi langsung menonaktifkan / suspend PT terkait jika diminta
        if ($request->boolean('suspend_terlapor') && $laporan->terlapor_id) {
            $pt = User::find($laporan->terlapor_id);
            if ($pt && $pt->role === 'admin_pt') {
                $pt->is_suspended = true;
                $pt->alasan_suspend = "Ditangguhkan terkait pengaduan #LAP-{$laporan->id}: " . ($request->tindakan_superadmin ?: $laporan->judul);
                $pt->save();

                // Nonaktifkan loker aktif milik PT tersebut
                Pekerjaan::where('user_id', $pt->id)->update(['status_loker' => 'ditutup']);
            }
        }

        return redirect()->route('superadmin.laporan.index')->with('success', "Status pengaduan #LAP-{$laporan->id} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $this->ensureLaporanTableExists();

        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('superadmin.laporan.index')->with('success', 'Laporan pengaduan berhasil dihapus.');
    }

    public function cetak(Request $request)
    {
        $this->ensureLaporanTableExists();

        $periode = $request->query('periode', 'all');
        
        $jobQuery = Pekerjaan::with('user');
        $ptQuery = User::where('role', 'admin_pt');
        $appQuery = Application::with(['user', 'pekerjaan']);
        $laporanQuery = Laporan::with(['pelapor', 'terlapor', 'pekerjaan']);

        if ($periode === 'hari_ini') {
            $jobQuery->whereDate('created_at', today());
            $ptQuery->whereDate('created_at', today());
            $appQuery->whereDate('created_at', today());
            $laporanQuery->whereDate('created_at', today());
            $periodeText = 'Hari Ini (' . now()->translatedFormat('d F Y') . ')';
        } elseif ($periode === '7_hari') {
            $jobQuery->where('created_at', '>=', now()->subDays(7));
            $ptQuery->where('created_at', '>=', now()->subDays(7));
            $appQuery->where('created_at', '>=', now()->subDays(7));
            $laporanQuery->where('created_at', '>=', now()->subDays(7));
            $periodeText = '7 Hari Terakhir';
        } elseif ($periode === '30_hari') {
            $jobQuery->where('created_at', '>=', now()->subDays(30));
            $ptQuery->where('created_at', '>=', now()->subDays(30));
            $appQuery->where('created_at', '>=', now()->subDays(30));
            $laporanQuery->where('created_at', '>=', now()->subDays(30));
            $periodeText = '30 Hari Terakhir';
        } else {
            $periodeText = 'Seluruh Periode (Semua Waktu)';
        }

        $pekerjaans = $jobQuery->latest()->get();
        $mitraPTs = $ptQuery->latest()->get();
        $applications = $appQuery->latest()->get();
        $laporans = $laporanQuery->latest()->get();

        return view('superadmin.laporan.cetak', compact(
            'periodeText',
            'pekerjaans',
            'mitraPTs',
            'applications',
            'laporans'
        ));
    }
}

