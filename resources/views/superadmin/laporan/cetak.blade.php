<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Operasional Platform - Luang.In</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans text-gray-900 p-6 sm:p-10 min-h-screen">

    <div class="max-w-5xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-sm border border-gray-200 print:border-none print:shadow-none print:p-0">

        <!-- Top Print Action Bar (Hidden on Print) -->
        <div class="no-print flex items-center justify-between pb-6 mb-6 border-b border-gray-200">
            <div>
                <a href="{{ route('superadmin.laporan.index', ['tab' => 'rekap']) }}" class="text-xs font-bold text-gray-500 hover:text-gray-800 flex items-center gap-1">
                    ← Kembali ke Dashboard
                </a>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-[#6b21a8] text-white font-bold text-xs hover:bg-[#581c87] shadow-sm transition">
                    🖨️ Cetak / Simpan PDF
                </button>
            </div>
        </div>

        <!-- Kop Surat Laporan Resmi -->
        <div class="flex items-center justify-between pb-6 border-b-2 border-gray-900">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#6b21a8] text-white flex items-center justify-center font-extrabold text-2xl">
                    L
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-gray-900">LUANG.IN PLATFORM</h1>
                    <p class="text-xs text-gray-500 font-semibold tracking-wide uppercase">Sistem Portal Kerja Harian & Serabutan Terpadu</p>
                    <p class="text-[11px] text-gray-400">Laporan Resmi Aktivitas Operasional & Kepatuhan Mitra</p>
                </div>
            </div>
            <div class="text-right text-xs space-y-0.5">
                <div class="font-bold text-gray-900">REKAPITULASI RESMI</div>
                <div class="text-gray-600">Periode: <span class="font-bold text-purple-900">{{ $periodeText }}</span></div>
                <div class="text-gray-400 text-[11px]">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</div>
            </div>
        </div>

        <!-- Ringkasan Eksekutif (Metrics) -->
        <div class="mt-8 space-y-3">
            <h2 class="text-sm font-black text-gray-800 uppercase tracking-wider">1. Ringkasan Eksekutif Operasional</h2>
            <div class="grid grid-cols-4 gap-3">
                <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Total Mitra PT</span>
                    <p class="text-xl font-black text-gray-900 mt-1">{{ $mitraPTs->count() }} Perusahaan</p>
                    <span class="text-[10px] text-emerald-700 font-semibold">{{ $mitraPTs->where('status_verifikasi_pt', 'terverifikasi')->count() }} Terverifikasi</span>
                </div>
                <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Lowongan Dibuat</span>
                    <p class="text-xl font-black text-gray-900 mt-1">{{ $pekerjaans->count() }} Loker</p>
                    <span class="text-[10px] text-purple-700 font-semibold">{{ $pekerjaans->where('status_moderasi', 'disetujui')->count() }} Disetujui</span>
                </div>
                <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Pelamar Masuk</span>
                    <p class="text-xl font-black text-gray-900 mt-1">{{ $applications->count() }} Pelamar</p>
                    <span class="text-[10px] text-emerald-700 font-semibold">{{ $applications->where('status', 'diterima')->count() }} Diterima Bekerja</span>
                </div>
                <div class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Pengaduan Masuk</span>
                    <p class="text-xl font-black text-gray-900 mt-1">{{ $laporans->count() }} Aduan</p>
                    <span class="text-[10px] text-blue-700 font-semibold">{{ $laporans->where('status', 'selesai')->count() }} Tuntas Ditindak</span>
                </div>
            </div>
        </div>

        <!-- Tabel 1: Rekapitulasi Mitra Perusahaan -->
        <div class="mt-8 space-y-3">
            <h2 class="text-sm font-black text-gray-800 uppercase tracking-wider">2. Daftar Mitra Perusahaan (Admin PT)</h2>
            <table class="w-full text-xs text-left border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 font-bold text-gray-700 uppercase">
                    <tr>
                        <th class="p-2.5 border-b border-gray-200">No</th>
                        <th class="p-2.5 border-b border-gray-200">Nama Perusahaan</th>
                        <th class="p-2.5 border-b border-gray-200">Email & Kontak</th>
                        <th class="p-2.5 border-b border-gray-200">Domisili</th>
                        <th class="p-2.5 border-b border-gray-200 text-right">Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mitraPTs as $idx => $pt)
                        <tr>
                            <td class="p-2.5 text-gray-500">{{ $idx + 1 }}</td>
                            <td class="p-2.5 font-bold text-gray-900">{{ $pt->name }}</td>
                            <td class="p-2.5 text-gray-600">{{ $pt->email }} / WA: {{ $pt->whatsapp }}</td>
                            <td class="p-2.5 text-gray-600">{{ $pt->domisili ?? '-' }}</td>
                            <td class="p-2.5 text-right font-bold {{ $pt->status_verifikasi_pt === 'terverifikasi' ? 'text-emerald-700' : ($pt->status_verifikasi_pt === 'ditolak' ? 'text-red-700' : 'text-amber-700') }}">
                                {{ strtoupper($pt->status_verifikasi_pt ?? 'MENUNGGU') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">Tidak ada data mitra perusahaan pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel 2: Rekapitulasi Lowongan & Moderasi -->
        <div class="mt-8 space-y-3">
            <h2 class="text-sm font-black text-gray-800 uppercase tracking-wider">3. Rekapitulasi Lowongan Pekerjaan Serabutan</h2>
            <table class="w-full text-xs text-left border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 font-bold text-gray-700 uppercase">
                    <tr>
                        <th class="p-2.5 border-b border-gray-200">No</th>
                        <th class="p-2.5 border-b border-gray-200">Judul Pekerjaan</th>
                        <th class="p-2.5 border-b border-gray-200">Mitra PT</th>
                        <th class="p-2.5 border-b border-gray-200">Upah / Shift</th>
                        <th class="p-2.5 border-b border-gray-200 text-right">Status Moderasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pekerjaans as $idx => $job)
                        <tr>
                            <td class="p-2.5 text-gray-500">{{ $idx + 1 }}</td>
                            <td class="p-2.5 font-bold text-gray-900">{{ $job->judul }}</td>
                            <td class="p-2.5 text-purple-700 font-medium">{{ $job->user->name ?? 'Mitra Perusahaan' }}</td>
                            <td class="p-2.5 text-gray-800">Rp {{ number_format((float)$job->upah, 0, ',', '.') }} ({{ $job->durasi }})</td>
                            <td class="p-2.5 text-right font-bold {{ $job->status_moderasi === 'disetujui' ? 'text-emerald-700' : ($job->status_moderasi === 'ditolak' ? 'text-red-700' : 'text-amber-700') }}">
                                {{ strtoupper($job->status_moderasi) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">Tidak ada data lowongan pekerjaan pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel 3: Rekapitulasi Pengaduan & Kepatuhan -->
        <div class="mt-8 space-y-3">
            <h2 class="text-sm font-black text-gray-800 uppercase tracking-wider">4. Rekapitulasi Pengaduan & Tindak Lanjut Masalah</h2>
            <table class="w-full text-xs text-left border border-gray-200 rounded-xl overflow-hidden">
                <thead class="bg-gray-100 font-bold text-gray-700 uppercase">
                    <tr>
                        <th class="p-2.5 border-b border-gray-200">ID</th>
                        <th class="p-2.5 border-b border-gray-200">Kategori & Judul Laporan</th>
                        <th class="p-2.5 border-b border-gray-200">Pelapor / Terlapor</th>
                        <th class="p-2.5 border-b border-gray-200">Tindakan Superadmin</th>
                        <th class="p-2.5 border-b border-gray-200 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($laporans as $lap)
                        <tr>
                            <td class="p-2.5 font-bold text-gray-700">#LAP-{{ $lap->id }}</td>
                            <td class="p-2.5 max-w-xs">
                                <span class="font-bold text-gray-900 block">{{ $lap->judul }}</span>
                                <span class="text-[10px] text-purple-700">Kategori: {{ $lap->kategori_label }}</span>
                            </td>
                            <td class="p-2.5 text-gray-600">
                                <div><span class="text-[10px] uppercase font-bold text-gray-400">Oleh:</span> {{ $lap->nama_pelapor ?? ($lap->pelapor->name ?? 'Anonim') }}</div>
                                @if($lap->terlapor)
                                    <div><span class="text-[10px] uppercase font-bold text-gray-400">Terlapor:</span> {{ $lap->terlapor->name }}</div>
                                @endif
                            </td>
                            <td class="p-2.5 text-gray-700 italic">
                                {{ $lap->tindakan_superadmin ?: 'Menunggu investigasi' }}
                            </td>
                            <td class="p-2.5 text-right font-bold {{ $lap->status === 'selesai' ? 'text-emerald-700' : ($lap->status === 'proses' ? 'text-blue-700' : ($lap->status === 'ditolak' ? 'text-gray-500' : 'text-amber-700')) }}">
                                {{ strtoupper($lap->status) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">Tidak ada laporan pengaduan pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan Pengesahan -->
        <div class="mt-12 pt-8 border-t border-gray-200 flex items-center justify-between text-xs text-gray-600">
            <div>
                <p>Dokumen rekapitulasi dihasilkan secara otomatis oleh sistem.</p>
                <p class="text-gray-400">Platform Kerja Serabutan Luang.In &copy; {{ date('Y') }}</p>
            </div>
            <div class="text-center w-48 space-y-12">
                <p>Superadmin Operasional,</p>
                <p class="font-bold text-gray-900 border-t border-gray-400 pt-1">
                    {{ auth()->user()->name ?? 'Superadmin Luang.In' }}
                </p>
            </div>
        </div>

    </div>

</body>

</html>

