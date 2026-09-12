<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Superadmin - Luang.In</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#fcf9f8] font-sans antialiased text-gray-800 min-h-screen">
    
    <!-- Top Navbar Superadmin -->
    <header class="bg-white border-b border-gray-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#6b21a8] text-white flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[24px]">shield_person</span>
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-gray-900 leading-tight">Luang.In Superadmin</h1>
                    <p class="text-[11px] text-gray-400 font-semibold">Panel Moderasi & Verifikasi Mitra</p>
                </div>
            </div>

            <!-- Navigation Links 3 Pilar -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin_pt.dashboard') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#ede9fe] text-[#6b21a8] transition">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                    <span>Panel Moderasi</span>
                </a>
                <a href="{{ route('superadmin.laporan.index') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[18px]">report</span>
                    <span>Kelola Laporan</span>
                    @if(isset($laporanPendingCount) && $laporanPendingCount > 0)
                        <span class="px-2 py-0.5 text-[10px] rounded-full bg-red-500 text-white font-black">
                            {{ $laporanPendingCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('superadmin.akun.index') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                    <span>Kelola Akun PT</span>
                    @if(isset($totalPTBermasalahCount) && $totalPTBermasalahCount > 0)
                        <span class="px-2 py-0.5 text-[10px] rounded-full bg-rose-500 text-white font-black">
                            {{ $totalPTBermasalahCount }}
                        </span>
                    @endif
                </a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Superadmin Aktif: {{ auth()->user()->name ?? 'Superadmin' }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 text-xs font-bold transition">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">

        <!-- Flash Message -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2.5 shadow-sm">
                <span class="material-symbols-outlined text-[22px] text-emerald-600 shrink-0">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center gap-2.5 shadow-sm">
                <span class="material-symbols-outlined text-[22px] text-red-600 shrink-0">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mitra PT Menunggu ACC</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $pendingPT->count() }} Pengajuan</h3>
                    <p class="text-xs text-gray-500 mt-1">Akun perusahaan perlu verifikasi</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-inner">
                    <span class="material-symbols-outlined text-[28px]">domain_verification</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lowongan Menunggu Moderasi</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $pendingPekerjaan->count() }} Lowongan</h3>
                    <p class="text-xs text-gray-500 mt-1">Pekerjaan baru menunggu tayang</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#6b21a8] flex items-center justify-center shadow-inner">
                    <span class="material-symbols-outlined text-[28px]">policy</span>
                </div>
            </div>

            <a href="{{ route('superadmin.laporan.index') }}"
               class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex items-center justify-between hover:border-purple-300 hover:shadow-md transition group">
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-bold text-red-500 uppercase tracking-wider">Pengaduan Masalah</span>
                        @if(isset($laporanPendingCount) && $laporanPendingCount > 0)
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $laporanPendingCount ?? 0 }} Perlu Tindak</h3>
                    <p class="text-xs text-purple-700 font-semibold mt-1 group-hover:underline flex items-center gap-1">
                        <span>Buka Kelola Laporan</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shadow-inner">
                    <span class="material-symbols-outlined text-[28px]">report_problem</span>
                </div>
            </a>
        </div>

        <!-- 1. TABEL VERIFIKASI AKUN PT -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-gray-900">Daftar Akun Mitra PT Menunggu Persetujuan (ACC)</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Verifikasi identitas dan domisili perusahaan sebelum memberikan izin login</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold">
                    {{ $pendingPT->count() }} Menunggu
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50/70 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Nama Perusahaan / PT</th>
                            <th class="px-6 py-3.5">Kontak & Email</th>
                            <th class="px-6 py-3.5">Domisili</th>
                            <th class="px-6 py-3.5">Tanggal Daftar</th>
                            <th class="px-6 py-3.5 text-right">Keputusan Superadmin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingPT as $pt)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-[#6b21a8] font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($pt->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 block leading-tight">{{ $pt->name }}</span>
                                            <span class="text-[11px] text-gray-400">ID PT: #PT-{{ $pt->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs space-y-0.5">
                                        <div class="font-semibold text-gray-800">{{ $pt->email }}</div>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pt->whatsapp) }}" target="_blank"
                                           class="text-emerald-600 hover:underline flex items-center gap-1 font-medium">
                                            <span>WA: {{ $pt->whatsapp }}</span>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs font-medium text-gray-600">
                                    {{ $pt->domisili ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $pt->created_at ? $pt->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Tombol Tolak -->
                                        <form action="{{ route('superadmin.pt.verif', $pt->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin MENOLAK pengajuan PT {{ $pt->name }}?')"
                                                    class="px-3.5 py-1.5 rounded-xl bg-white border border-gray-200 text-red-600 hover:bg-red-50 text-xs font-bold transition shadow-sm">
                                                Tolak
                                            </button>
                                        </form>

                                        <!-- Tombol Terima / ACC -->
                                        <form action="{{ route('superadmin.pt.verif', $pt->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="terverifikasi">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-4 py-1.5 rounded-xl bg-[#6b21a8] hover:bg-[#581c87] text-white text-xs font-bold transition shadow-sm">
                                                <span class="material-symbols-outlined text-[15px]">check</span>
                                                <span>Setujui (ACC)</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <span class="material-symbols-outlined text-[42px] text-gray-300">check_circle</span>
                                    <p class="text-sm font-semibold text-gray-600 mt-2">Tidak ada pendaftaran PT baru yang menunggu verifikasi saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. TABEL MODERASI LOWONGAN PEKERJAAN -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-gray-900">Moderasi Lowongan Pekerjaan Baru</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pastikan kualifikasi, durasi, dan upah pekerjaan layak untuk pekerja lokal</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-800 border border-purple-200 text-xs font-bold">
                    {{ $pendingPekerjaan->count() }} Lowongan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50/70 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Perusahaan & Judul Loker</th>
                            <th class="px-6 py-3.5">Upah & Shift Durasi</th>
                            <th class="px-6 py-3.5">Tanggal Dibuat</th>
                            <th class="px-6 py-3.5 text-right">Moderasi Superadmin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingPekerjaan as $job)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <span class="font-bold text-gray-900 block leading-tight">{{ $job->judul }}</span>
                                        <span class="text-xs text-purple-700 font-semibold">{{ $job->user->name ?? 'Perusahaan' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs">
                                        <span class="font-bold text-emerald-700 block">Rp {{ number_format((float)$job->upah, 0, ',', '.') }}</span>
                                        <span class="text-gray-500">{{ $job->durasi }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $job->created_at ? $job->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('superadmin.pekerjaan.moderasi', $job->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_moderasi" value="ditolak">
                                            <button type="submit"
                                                    onclick="return confirm('Tolak penayangan lowongan ini?')"
                                                    class="px-3.5 py-1.5 rounded-xl bg-white border border-gray-200 text-red-600 hover:bg-red-50 text-xs font-bold transition shadow-sm">
                                                Tolak
                                            </button>
                                        </form>

                                        <form action="{{ route('superadmin.pekerjaan.moderasi', $job->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_moderasi" value="disetujui">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-4 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                                                <span class="material-symbols-outlined text-[15px]">check</span>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    <span class="material-symbols-outlined text-[42px] text-gray-300">task_alt</span>
                                    <p class="text-sm font-semibold text-gray-600 mt-2">Tidak ada lowongan baru yang perlu dimoderasi saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>

</html>