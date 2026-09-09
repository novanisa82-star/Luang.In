<?php

namespace App\Http\Controllers\AdminPt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PelamarController extends Controller
{
    /**
     * Tampilkan halaman Pelamar Masuk / Riwayat Pelamar
     */
    public function index(Request $request)
    {
        $adminId = Auth::id();

        // Ambil semua lowongan yang dimiliki oleh Admin PT yang sedang login
        $allLowongans = Pekerjaan::where('user_id', $adminId)->latest()->get();

        // Jika belum ada lowongan sama sekali untuk PT ini, kita otomatis siapkan lowongan contoh
        // agar pengguna langsung melihat tampilan seperti di mockup
        if ($allLowongans->isEmpty()) {
            $this->seedDemoForAdmin($adminId);
            $allLowongans = Pekerjaan::where('user_id', $adminId)->latest()->get();
        }

        // Tentukan lowongan mana yang sedang dipilih
        $selectedLowonganId = $request->query('pekerjaan_id');
        $selectedLowongan = null;

        if ($selectedLowonganId) {
            $selectedLowongan = $allLowongans->firstWhere('id', $selectedLowonganId);
        }

        if (!$selectedLowongan) {
            $selectedLowongan = $allLowongans->first();
        }

        // Query pelamar untuk lowongan yang dipilih
        $query = Application::query();

        if ($selectedLowongan) {
            $query->where('pekerjaan_id', $selectedLowongan->id);
        } else {
            $query->whereIn('pekerjaan_id', $allLowongans->pluck('id'));
        }

        $query->with(['user', 'pekerjaan']);

        // Jika belum ada pelamar untuk lowongan ini, buat data pelamar contoh
        if ($selectedLowongan && $query->count() === 0) {
            $this->seedDemoApplicants($selectedLowongan);
            $query = Application::where('pekerjaan_id', $selectedLowongan->id)->with(['user', 'pekerjaan']);
        }

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
        $totalPelamar = Application::where('pekerjaan_id', $selectedLowongan?->id)->count();
        $diterimaCount = Application::where('pekerjaan_id', $selectedLowongan?->id)
            ->where('status', 'diterima')
            ->count();
        $targetKebutuhan = 6;

        // Paginasi 4 data per halaman sesuai tampilan kartu di mockup
        $pelamars = $query->paginate(4)->withQueryString();

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

    /**
     * Helper privat untuk membuat lowongan contoh jika PT belum punya data
     */
    private function seedDemoForAdmin($adminId)
    {
        $lowongan = Pekerjaan::create([
            'user_id' => $adminId,
            'judul' => 'Tenaga Angkut Gudang Harian',
            'deskripsi' => "Dibutuhkan tenaga bongkar muat dan angkut barang pergudangan harian. Kondisi fisik prima, siap lembur dan kerja tim.\n\nLokasi: Rungkut Industri Raya No. 45, Surabaya\nSkill yang dibutuhkan: Bongkar Muat, Fisik Prima, Logistik Gudang",
            'latitude' => -7.320000,
            'longitude' => 112.760000,
            'upah' => '150000',
            'durasi' => 'Shift Pagi (07.00 - 15.00)',
            'status_moderasi' => 'disetujui',
            'status_loker' => 'aktif',
        ]);

        $this->seedDemoApplicants($lowongan);
    }

    /**
     * Helper privat untuk membuat pelamar contoh sesuai dengan yang ada di mockup
     */
    private function seedDemoApplicants($lowongan)
    {
        $sampleData = [
            [
                'name' => 'Budi Prasetyo',
                'email' => 'budi.prasetyo@gmail.com',
                'whatsapp' => '081234567801',
                'domisili' => 'Rungkut',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Agus Santoso',
                'email' => 'agus.santoso@gmail.com',
                'whatsapp' => '081234567802',
                'domisili' => 'Wonokromo',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Rian Wahyudi',
                'email' => 'rian.wahyudi@gmail.com',
                'whatsapp' => '081234567803',
                'domisili' => 'Sukolilo',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Deni Pratama',
                'email' => 'deni.pratama@gmail.com',
                'whatsapp' => '081234567804',
                'domisili' => 'Sawahan',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti.rahma@gmail.com',
                'whatsapp' => '081234567805',
                'domisili' => 'Gubeng',
                'status' => 'diterima',
            ],
            [
                'name' => 'Eko Prasetya',
                'email' => 'eko.prasetya@gmail.com',
                'whatsapp' => '081234567806',
                'domisili' => 'Wonocolo',
                'status' => 'diterima',
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@gmail.com',
                'whatsapp' => '081234567807',
                'domisili' => 'Tegalsari',
                'status' => 'diterima',
            ],
            [
                'name' => 'Bayu Aditya',
                'email' => 'bayu.aditya@gmail.com',
                'whatsapp' => '081234567808',
                'domisili' => 'Tambaksari',
                'status' => 'diterima',
            ],
            [
                'name' => 'Dimas Saputra',
                'email' => 'dimas.saputra@gmail.com',
                'whatsapp' => '081234567809',
                'domisili' => 'Kenjeran',
                'status' => 'ditolak',
            ],
            [
                'name' => 'Wahyu Hidayat',
                'email' => 'wahyu.hidayat@gmail.com',
                'whatsapp' => '081234567810',
                'domisili' => 'Jambangan',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Arif Rahman',
                'email' => 'arif.rahman@gmail.com',
                'whatsapp' => '081234567811',
                'domisili' => 'Sukomanunggal',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@gmail.com',
                'whatsapp' => '081234567812',
                'domisili' => 'Wiyung',
                'status' => 'menunggu',
            ],
        ];

        foreach ($sampleData as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'whatsapp' => $item['whatsapp'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'domisili' => $item['domisili'],
                ]
            );

            Application::firstOrCreate(
                [
                    'pekerjaan_id' => $lowongan->id,
                    'user_id' => $user->id,
                ],
                [
                    'status' => $item['status'],
                ]
            );
        }
    }
}

