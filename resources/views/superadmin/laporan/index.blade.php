<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan & Pengaduan - Superadmin Luang.In</title>
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
                    <p class="text-[11px] text-gray-400 font-semibold">Pusat Kelola Laporan & Pengaduan</p>
                </div>
            </div>

            <!-- Navigation Links 3 Pilar -->
            <div class="flex items-center gap-2">
                <a href="{{ route('admin_pt.dashboard') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                    <span>Panel Moderasi</span>
                </a>
                <a href="{{ route('superadmin.laporan.index') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#ede9fe] text-[#6b21a8] transition">
                    <span class="material-symbols-outlined text-[18px]">report</span>
                    <span>Kelola Laporan</span>
                </a>
                <a href="{{ route('superadmin.akun.index') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                    <span>Kelola Akun PT</span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-gray-600 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ auth()->user()->name ?? 'Superadmin' }}</span>
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

        <!-- Flash Messages -->
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

        <!-- Tab Switching Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200/80 pb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('superadmin.laporan.index', ['tab' => 'pengaduan']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all {{ $tab === 'pengaduan' ? 'bg-[#6b21a8] text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined text-[18px]">gavel</span>
                    <span>Pengaduan & Pelanggaran</span>
                    @if($laporanMenunggu > 0)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-red-500 text-white font-extrabold ml-1">
                            {{ $laporanMenunggu }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('superadmin.laporan.index', ['tab' => 'rekap']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all {{ $tab === 'rekap' ? 'bg-[#6b21a8] text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    <span class="material-symbols-outlined text-[18px]">analytics</span>
                    <span>Rekapitulasi Platform & Cetak</span>
                </a>
            </div>

            @if($tab === 'pengaduan')
                <button type="button" onclick="document.getElementById('modalTambahLaporan').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-purple-200 text-[#6b21a8] hover:bg-purple-50 text-xs font-bold transition shadow-sm self-start sm:self-auto">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>Catat Pengaduan Baru</span>
                </button>
            @endif
        </div>

        @if($tab === 'pengaduan')
            <!-- ================= TAB 1: PENGADUAN & PELANGGARAN ================= -->

            <!-- Summary Cards Pengaduan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Aduan</span>
                        <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-extrabold text-gray-900 mt-2">{{ $totalLaporan }} Kasus</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Semua laporan terdaftar</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Menunggu Tindakan</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">pending_actions</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-extrabold text-amber-600 mt-2">{{ $laporanMenunggu }} Pengaduan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Perlu investigasi superadmin</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Sedang Ditinjau</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">troubleshoot</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-extrabold text-blue-600 mt-2">{{ $laporanProses }} Kasus</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Dalam proses mediasi/tindak</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Selesai Ditindak</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[18px]">task_alt</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">{{ $laporanSelesai }} Selesai</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Kasus tuntas diselesaikan</p>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Filter Status Pills -->
                <div class="flex items-center gap-1.5 flex-wrap w-full md:w-auto">
                    <a href="{{ route('superadmin.laporan.index', array_merge(request()->query(), ['status' => null, 'tab' => 'pengaduan'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !$statusFilter ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua Status ({{ $totalLaporan }})
                    </a>
                    <a href="{{ route('superadmin.laporan.index', array_merge(request()->query(), ['status' => 'menunggu', 'tab' => 'pengaduan'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'menunggu' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                        Menunggu ({{ $laporanMenunggu }})
                    </a>
                    <a href="{{ route('superadmin.laporan.index', array_merge(request()->query(), ['status' => 'proses', 'tab' => 'pengaduan'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'proses' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                        Diproses ({{ $laporanProses }})
                    </a>
                    <a href="{{ route('superadmin.laporan.index', array_merge(request()->query(), ['status' => 'selesai', 'tab' => 'pengaduan'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'selesai' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                        Selesai ({{ $laporanSelesai }})
                    </a>
                    <a href="{{ route('superadmin.laporan.index', array_merge(request()->query(), ['status' => 'ditolak', 'tab' => 'pengaduan'])) }}"
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'ditolak' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }}">
                        Ditolak ({{ $laporanDitolak }})
                    </a>
                </div>

                <!-- Form Search & Category -->
                <form action="{{ route('superadmin.laporan.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto m-0">
                    <input type="hidden" name="tab" value="pengaduan">
                    @if($statusFilter)
                        <input type="hidden" name="status" value="{{ $statusFilter }}">
                    @endif

                    <select name="kategori" onchange="this.form.submit()"
                            class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Semua Kategori</option>
                        <option value="penipuan_loker" {{ $kategoriFilter === 'penipuan_loker' ? 'selected' : '' }}>Dugaan Penipuan Loker</option>
                        <option value="upah_tidak_sesuai" {{ $kategoriFilter === 'upah_tidak_sesuai' ? 'selected' : '' }}>Upah Tidak Sesuai</option>
                        <option value="pelanggaran_sop" {{ $kategoriFilter === 'pelanggaran_sop' ? 'selected' : '' }}>Pelanggaran SOP</option>
                        <option value="kontak_palsu" {{ $kategoriFilter === 'kontak_palsu' ? 'selected' : '' }}>Kontak / PIC Palsu</option>
                        <option value="pekerja_mangkir" {{ $kategoriFilter === 'pekerja_mangkir' ? 'selected' : '' }}>Pekerja Mangkir</option>
                        <option value="lainnya" {{ $kategoriFilter === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    <div class="relative flex-1 md:w-56">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul / pelapor..."
                               class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <span class="material-symbols-outlined absolute left-2.5 top-2.5 text-gray-400 text-[16px]">search</span>
                    </div>

                    @if($search || $kategoriFilter)
                        <a href="{{ route('superadmin.laporan.index', ['tab' => 'pengaduan', 'status' => $statusFilter]) }}"
                           class="p-2 text-gray-400 hover:text-gray-600 transition" title="Reset filter">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tabel Daftar Laporan Pengaduan -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-extrabold text-gray-900">Daftar Pengaduan & Laporan Masalah</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Tinjau laporan dugaan penipuan, perselisihan upah, atau pelanggaran SOP pekerjaan</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-purple-50 text-[#6b21a8] border border-purple-200 text-xs font-bold">
                        {{ $laporans->total() }} Laporan Ditemukan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm divide-y divide-gray-100">
                        <thead class="bg-gray-50/70 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3.5">ID & Kategori</th>
                                <th class="px-6 py-3.5">Judul & Kronologi Pengaduan</th>
                                <th class="px-6 py-3.5">Pihak Terkait</th>
                                <th class="px-6 py-3.5">Status & Tindakan Superadmin</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($laporans as $lap)
                                <tr class="hover:bg-gray-50/60 transition align-top">
                                    <td class="px-6 py-4">
                                        <div class="space-y-1.5">
                                            <span class="text-xs font-extrabold text-gray-900 block">#LAP-{{ $lap->id }}</span>
                                            <span class="inline-block px-2.5 py-1 rounded-lg text-[11px] font-bold border {{ $lap->kategori_badge }}">
                                                {{ $lap->kategori_label }}
                                            </span>
                                            <span class="text-[11px] text-gray-400 block">
                                                {{ $lap->created_at ? $lap->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 max-w-sm">
                                        <div class="space-y-1">
                                            <h4 class="font-bold text-gray-900 leading-tight">{{ $lap->judul }}</h4>
                                            <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">{{ $lap->deskripsi }}</p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-xs">
                                        <div class="space-y-2">
                                            <div>
                                                <span class="text-gray-400 block text-[10px] uppercase font-bold">Pelapor:</span>
                                                <span class="font-bold text-gray-800">{{ $lap->nama_pelapor ?? ($lap->pelapor->name ?? 'Anonim') }}</span>
                                                @if($lap->kontak_pelapor)
                                                    <span class="text-gray-500 block text-[11px]">WA: {{ $lap->kontak_pelapor }}</span>
                                                @endif
                                            </div>

                                            @if($lap->terlapor || $lap->pekerjaan)
                                                <div class="pt-1 border-t border-gray-100">
                                                    <span class="text-gray-400 block text-[10px] uppercase font-bold">Terlapor / Lowongan:</span>
                                                    @if($lap->terlapor)
                                                        <span class="font-semibold text-purple-700 block">{{ $lap->terlapor->name }}</span>
                                                    @endif
                                                    @if($lap->pekerjaan)
                                                        <span class="text-gray-600 text-[11px] block truncate">Loker: {{ $lap->pekerjaan->judul }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            @if($lap->status === 'menunggu')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu Investigasi
                                                </span>
                                            @elseif($lap->status === 'proses')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-800 border border-blue-200 text-xs font-bold">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Sedang Ditinjau
                                                </span>
                                            @elseif($lap->status === 'selesai')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                                                    <span class="material-symbols-outlined text-[14px]">check</span> Selesai Ditindak
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200 text-xs font-bold">
                                                    <span class="material-symbols-outlined text-[14px]">close</span> Laporan Ditolak
                                                </span>
                                            @endif

                                            @if($lap->tindakan_superadmin)
                                                <div class="p-2 rounded-xl bg-gray-50 border border-gray-100 text-[11px] text-gray-700">
                                                    <span class="font-bold text-gray-900 block text-[10px] uppercase">Catatan Superadmin:</span>
                                                    <span>{{ $lap->tindakan_superadmin }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- Tombol Tindak Lanjut (Modal) -->
                                            <button type="button" onclick="bukaModalTindak({{ $lap->id }}, '{{ $lap->status }}', '{{ addslashes($lap->tindakan_superadmin ?? '') }}', '{{ addslashes($lap->judul) }}')"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-[#6b21a8] text-white hover:bg-[#581c87] text-xs font-bold transition shadow-sm">
                                                <span class="material-symbols-outlined text-[15px]">edit_note</span>
                                                <span>Tindak</span>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('superadmin.laporan.destroy', $lap->id) }}" method="POST" class="inline m-0"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus Laporan">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <span class="material-symbols-outlined text-[42px] text-gray-300">verified</span>
                                        <p class="text-sm font-semibold text-gray-600 mt-2">Tidak ada laporan pengaduan yang cocok dengan filter saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($laporans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $laporans->links() }}
                    </div>
                @endif
            </div>

        @else
            <!-- ================= TAB 2: REKAPITULASI & CETAK LAPORAN ================= -->

            <!-- Section Rekapitulasi Platform -->
            <div class="space-y-6">
                <!-- Banner Cetak -->
                <div class="bg-gradient-to-r from-[#6b21a8] to-[#4c1d95] rounded-3xl p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2">
                        <span class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-sm">
                            Pusat Laporan & Ekspor
                        </span>
                        <h2 class="text-2xl font-extrabold text-white">Laporan Rekapitulasi Aktivitas Platform</h2>
                        <p class="text-sm text-purple-100 max-w-xl">
                            Unduh atau cetak laporan resmi operasional platform Luang.In (data mitra perusahaan, pekerjaan serabutan, pelamar terverifikasi, dan status kepatuhan).
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                        <div class="dropdown relative w-full sm:w-auto">
                            <select id="periodeCetakSelect"
                                    class="w-full sm:w-auto px-4 py-3 bg-white/10 border border-white/30 text-white font-bold rounded-2xl text-xs focus:outline-none focus:bg-purple-900">
                                <option value="all" class="text-gray-900">Seluruh Waktu (Lengkap)</option>
                                <option value="30_hari" class="text-gray-900">30 Hari Terakhir</option>
                                <option value="7_hari" class="text-gray-900">7 Hari Terakhir</option>
                                <option value="hari_ini" class="text-gray-900">Hari Ini</option>
                            </select>
                        </div>

                        <button type="button" onclick="bukaHalamanCetak()"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-white text-[#6b21a8] hover:bg-purple-50 font-extrabold text-xs shadow-md transition transform hover:-translate-y-0.5">
                            <span class="material-symbols-outlined text-[18px]">print</span>
                            <span>Cetak / Simpan PDF Laporan</span>
                        </button>
                    </div>
                </div>

                <!-- Grid 4 Pilar Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <!-- 1. Mitra Perusahaan -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Mitra Perusahaan</span>
                                <span class="w-10 h-10 rounded-xl bg-purple-50 text-[#6b21a8] flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">domain</span>
                                </span>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalPT }} Perusahaan</h3>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-500">Terverifikasi:</span>
                            <span class="font-bold text-emerald-600">{{ $ptTerverifikasi }} PT ({{ $totalPT > 0 ? round(($ptTerverifikasi/$totalPT)*100) : 0 }}%)</span>
                        </div>
                    </div>

                    <!-- 2. Lowongan Pekerjaan -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Loker Dibuat</span>
                                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">work</span>
                                </span>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalLoker }} Loker</h3>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-500">Disetujui Moderasi:</span>
                            <span class="font-bold text-blue-600">{{ $lokerDisetujui }} Tayang</span>
                        </div>
                    </div>

                    <!-- 3. Pelamar & Pekerja -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lamaran Masuk</span>
                                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">group</span>
                                </span>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalPelamar }} Pelamar</h3>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-500">Diterima Kerja:</span>
                            <span class="font-bold text-emerald-600">{{ $pelamarDiterima }} Tenaga Kerja</span>
                        </div>
                    </div>

                    <!-- 4. Laporan Diselesaikan -->
                    <div class="bg-white rounded-2xl border border-gray-200/80 p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Penyelesaian Aduan</span>
                                <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">verified</span>
                                </span>
                            </div>
                            <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $laporanSelesai }}/{{ $totalLaporan }}</h3>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-500">Tingkat Penanganan:</span>
                            <span class="font-bold text-purple-700">{{ $totalLaporan > 0 ? round(($laporanSelesai/$totalLaporan)*100) : 100 }}% Tuntas</span>
                        </div>
                    </div>
                </div>

                <!-- Info Panduan Cetak Laporan -->
                <div class="bg-purple-50/70 border border-purple-200/80 rounded-2xl p-6 flex items-start gap-4">
                    <span class="material-symbols-outlined text-[28px] text-[#6b21a8] shrink-0 mt-0.5">info</span>
                    <div class="text-xs text-purple-900 leading-relaxed space-y-1">
                        <h4 class="font-bold text-sm text-purple-950">Petunjuk Cetak Dokumen Laporan:</h4>
                        <p>Format cetak otomatis menyusun ringkasan eksekutif, tabel mitra usaha aktif, lowongan yang disetujui, dan rekapitulasi penyelesaian pengaduan.</p>
                        <p>Dapat disimpan sebagai file <strong>PDF</strong> melalui dialog cetak browser (pilih opsi <em>"Save as PDF / Simpan sebagai PDF"</em>).</p>
                    </div>
                </div>
            </div>

        @endif

    </main>

    <!-- ================= MODAL TINDAK LANJUT PENGADUAN ================= -->
    <div id="modalTindakLanjut" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5 animate-scale-in">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-purple-100 text-[#6b21a8] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">gavel</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-900" id="modalLaporanIdText">Tindak Lanjut Laporan</h3>
                        <p class="text-[11px] text-gray-400 font-semibold">Tentukan keputusan & catatan penanganan</p>
                    </div>
                </div>
                <button type="button" onclick="tutupModalTindak()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <p class="text-xs font-semibold text-gray-700 bg-gray-50 p-3 rounded-xl border border-gray-100" id="modalJudulLaporanText"></p>

            <form id="formTindakLanjut" action="" method="POST" class="space-y-4 m-0">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Status Keputusan Superadmin</label>
                    <select name="status" id="modalStatusSelect" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-purple-500 focus:outline-none bg-white">
                        <option value="menunggu">Menunggu Investigasi</option>
                        <option value="proses">Sedang Ditinjau / Mediasi (Diproses)</option>
                        <option value="selesai">Selesai Ditindak (Tuntas / Sanksi Diberikan)</option>
                        <option value="ditolak">Tolak Laporan (Tidak Valid / Selesai Tanpa Pelanggaran)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Catatan Tindakan / Keputusan Superadmin</label>
                    <textarea name="tindakan_superadmin" id="modalTindakanText" rows="3" required
                              placeholder="Tuliskan tindakan yang diambil (misal: Menghubungi PT via WA, Memberikan peringatan, Menutup loker penipuan, dll)..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                </div>

                <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl">
                    <label class="flex items-center gap-2 text-xs font-bold text-rose-800 cursor-pointer">
                        <input type="checkbox" name="suspend_terlapor" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                        <span>Nonaktifkan (Suspend) Akun PT Terlapor Sekaligus</span>
                    </label>
                    <p class="text-[10px] text-rose-600 mt-0.5 ml-5">Centang jika pelanggaran ini fatal dan akun PT perlu langsung di-down-kan / ditutup aksesnya.</p>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="tutupModalTindak()"
                            class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-[#6b21a8] text-white font-bold text-xs hover:bg-[#581c87] transition shadow-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">save</span>
                        <span>Simpan Keputusan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL CATAT PENGADUAN MANUAL ================= -->
    <div id="modalTambahLaporan" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-purple-100 text-[#6b21a8] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">add_alert</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-900">Catat Pengaduan / Masalah Baru</h3>
                        <p class="text-[11px] text-gray-400 font-semibold">Input pengaduan yang diterima secara manual</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('modalTambahLaporan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <form action="{{ route('superadmin.laporan.store') }}" method="POST" class="space-y-3.5 m-0">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Masalah *</label>
                    <select name="kategori" required
                            class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs font-bold text-gray-800 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        <option value="penipuan_loker">Dugaan Penipuan Loker</option>
                        <option value="upah_tidak_sesuai">Upah Tidak Sesuai Kesepakatan</option>
                        <option value="pelanggaran_sop">Pelanggaran SOP / Perilaku Tidak Pantas</option>
                        <option value="kontak_palsu">Kontak / PIC Palsu</option>
                        <option value="pekerja_mangkir">Pekerja Mangkir / Tidak Hadir</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Judul Ringkas Pengaduan *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Upah dipotong tanpa konfirmasi"
                           class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Pelapor</label>
                        <input type="text" name="nama_pelapor" placeholder="Nama pekerja / pelapor"
                               class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">No. WhatsApp Pelapor</label>
                        <input type="text" name="kontak_pelapor" placeholder="08xxxxxxxx"
                               class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Pihak Terlapor (Mitra PT jika ada)</label>
                    <select name="terlapor_id"
                            class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                        <option value="">-- Pilih Mitra PT Terkait (Opsional) --</option>
                        @foreach($listPT as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->name }} ({{ $pt->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kronologi / Rincian Laporan *</label>
                    <textarea name="deskripsi" rows="3" required placeholder="Jelaskan detail pengaduan, waktu kejadian, dan fakta yang dilaporkan..."
                              class="w-full px-3.5 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('modalTambahLaporan').classList.add('hidden')"
                            class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-[#6b21a8] text-white font-bold text-xs hover:bg-[#581c87] transition shadow-sm">
                        Simpan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal & Cetak -->
    <script>
        function bukaModalTindak(id, status, tindakan, judul) {
            const form = document.getElementById('formTindakLanjut');
            form.action = `/admin/superadmin/laporan/${id}/status`;
            document.getElementById('modalLaporanIdText').innerText = `Tindak Lanjut Laporan #LAP-${id}`;
            document.getElementById('modalJudulLaporanText').innerText = judul;
            document.getElementById('modalStatusSelect').value = status;
            document.getElementById('modalTindakanText').value = tindakan || '';
            document.getElementById('modalTindakLanjut').classList.remove('hidden');
        }

        function tutupModalTindak() {
            document.getElementById('modalTindakLanjut').classList.add('hidden');
        }

        function bukaHalamanCetak() {
            const periode = document.getElementById('periodeCetakSelect').value;
            window.open(`/admin/superadmin/laporan/cetak?periode=${periode}`, '_blank');
        }
    </script>

</body>

</html>

