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

<body class="bg-gray-50 font-sans antialiased text-gray-800 min-h-screen">

    <!-- Top Navbar Superadmin -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo & Title -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#6b21a8] text-white flex items-center justify-center shadow">
                    <span class="material-symbols-outlined text-[22px]">shield_person</span>
                </div>
                <div>
                    <h1 class="text-sm font-extrabold text-gray-900 leading-tight">Luang.In Superadmin</h1>
                    <p class="text-[11px] text-gray-400 font-medium">Panel Moderasi & Verifikasi Mitra</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center gap-1">
                <a href="{{ route('admin_pt.dashboard') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-purple-100 text-[#6b21a8] transition">
                    <span class="material-symbols-outlined text-[16px]">verified_user</span>
                    <span>Panel Moderasi</span>
                </a>
                <a href="{{ route('superadmin.laporan.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[16px]">report</span>
                    <span>Kelola Laporan</span>
                    @if(isset($laporanPendingCount) && $laporanPendingCount > 0)
                        <span class="px-1.5 py-0.5 text-[10px] rounded-full bg-red-500 text-white font-black">
                            {{ $laporanPendingCount }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('superadmin.akun.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-gray-600 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[16px]">manage_accounts</span>
                    <span>Kelola Akun PT</span>
                    @if(isset($totalPTBermasalahCount) && $totalPTBermasalahCount > 0)
                        <span class="px-1.5 py-0.5 text-[10px] rounded-full bg-rose-500 text-white font-black">
                            {{ $totalPTBermasalahCount }}
                        </span>
                    @endif
                </a>
            </nav>

            <!-- User & Logout -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Superadmin: {{ auth()->user()->name ?? 'Superadmin' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 text-xs font-bold transition">
                        <span class="material-symbols-outlined text-[16px]">logout</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-8">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-emerald-600 shrink-0">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-red-600 shrink-0">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Mitra PT -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Mitra PT Menunggu ACC</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $pendingPT->count() }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Pengajuan akun perusahaan</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[26px]">domain_verification</span>
                </div>
            </div>

            <!-- Card 2: Lowongan -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Lowongan Menunggu Moderasi</span>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $pendingPekerjaan->count() }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Pekerjaan baru menunggu tayang</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#6b21a8] flex items-center justify-center">
                    <span class="material-symbols-outlined text-[26px]">policy</span>
                </div>
            </div>

            <!-- Card 3: Laporan -->
            <a href="{{ route('superadmin.laporan.index') }}"
               class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex items-center justify-between hover:border-purple-300 hover:shadow-md transition group">
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-[11px] font-bold text-red-500 uppercase tracking-wider">Pengaduan Masalah</span>
                        @if(isset($laporanPendingCount) && $laporanPendingCount > 0)
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
                    </div>
                    <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $laporanPendingCount ?? 0 }}</h3>
                    <p class="text-xs text-purple-700 font-semibold mt-1 flex items-center gap-1 group-hover:underline">
                        <span>Buka Kelola Laporan</span>
                        <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[26px]">report_problem</span>
                </div>
            </a>
        </div>

        <!-- Tabel 1: Verifikasi Akun PT -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-extrabold text-gray-900">Daftar Akun Mitra PT Menunggu Persetujuan (ACC)</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Verifikasi identitas dan domisili perusahaan sebelum memberikan izin login</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold">
                    {{ $pendingPT->count() }} Menunggu
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3.5">Nama Perusahaan / PT</th>
                            <th class="px-6 py-3.5">Kontak & Email</th>
                            <th class="px-6 py-3.5">Domisili</th>
                            <th class="px-6 py-3.5">Tanggal Daftar</th>
                            <th class="px-6 py-3.5 text-right">Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingPT as $pt)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-purple-100 text-[#6b21a8] font-bold text-xs flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($pt->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-900 block text-sm leading-tight">{{ $pt->name }}</span>
                                            <span class="text-[11px] text-gray-400">ID: #PT-{{ $pt->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs space-y-0.5">
                                        <div class="font-medium text-gray-800">{{ $pt->email }}</div>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pt->whatsapp) }}" target="_blank"
                                           class="text-emerald-600 hover:underline font-medium">
                                            WA: {{ $pt->whatsapp }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600">
                                    {{ $pt->domisili ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $pt->created_at ? $pt->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('superadmin.pt.verif', $pt->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin MENOLAK pengajuan PT {{ $pt->name }}?')"
                                                    class="px-3.5 py-1.5 rounded-xl bg-white border border-gray-200 text-red-600 hover:bg-red-50 text-xs font-bold transition">
                                                Tolak
                                            </button>
                                        </form>
                                        <form action="{{ route('superadmin.pt.verif', $pt->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            <input type="hidden" name="status" value="terverifikasi">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-4 py-1.5 rounded-xl bg-[#6b21a8] hover:bg-[#581c87] text-white text-xs font-bold transition">
                                                <span class="material-symbols-outlined text-[14px]">check</span>
                                                <span>Setujui (ACC)</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <span class="material-symbols-outlined text-[48px] text-gray-200 block mx-auto">check_circle</span>
                                    <p class="text-sm font-semibold text-gray-500 mt-2">Tidak ada pendaftaran PT baru yang menunggu verifikasi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 2: Moderasi Lowongan -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-extrabold text-gray-900">Moderasi Lowongan Pekerjaan Baru</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pastikan kualifikasi, durasi, dan upah pekerjaan layak untuk pekerja lokal</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-200 text-xs font-bold">
                    {{ $pendingPekerjaan->count() }} Lowongan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3.5">Perusahaan & Judul Loker</th>
                            <th class="px-6 py-3.5">Upah & Durasi</th>
                            <th class="px-6 py-3.5">Tanggal Dibuat</th>
                            <th class="px-6 py-3.5 text-right">Moderasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pendingPekerjaan as $job)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-gray-900 block text-sm leading-tight">{{ $job->judul }}</span>
                                    <span class="text-xs text-purple-700 font-medium">{{ $job->user->name ?? 'Perusahaan' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-700 block text-sm">Rp {{ number_format((float)$job->upah, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-500">{{ $job->durasi }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    {{ $job->created_at ? $job->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('superadmin.pekerjaan.moderasi', $job->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_moderasi" value="ditolak">
                                            <button type="submit"
                                                    onclick="return confirm('Tolak penayangan lowongan ini?')"
                                                    class="px-3.5 py-1.5 rounded-xl bg-white border border-gray-200 text-red-600 hover:bg-red-50 text-xs font-bold transition">
                                                Tolak
                                            </button>
                                        </form>
                                        <form action="{{ route('superadmin.pekerjaan.moderasi', $job->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status_moderasi" value="disetujui">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-4 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                                <span class="material-symbols-outlined text-[14px]">check</span>
                                                <span>Setujui</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <span class="material-symbols-outlined text-[48px] text-gray-200 block mx-auto">task_alt</span>
                                    <p class="text-sm font-semibold text-gray-500 mt-2">Tidak ada lowongan baru yang perlu dimoderasi saat ini.</p>
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