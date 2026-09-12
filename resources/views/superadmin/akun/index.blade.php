<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Mitra PT - Superadmin Luang.In</title>
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
                    <p class="text-[11px] text-gray-400 font-semibold">Pusat Kelola & Pengawasan Akun Mitra</p>
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
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition">
                    <span class="material-symbols-outlined text-[18px]">report</span>
                    <span>Kelola Laporan</span>
                </a>
                <a href="{{ route('superadmin.akun.index') }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-[#ede9fe] text-[#6b21a8] transition">
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

        <!-- Summary Cards Akun PT -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Mitra Terdaftar</span>
                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">domain</span>
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-2">{{ $totalPT }} Perusahaan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Semua entitas PT</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Mitra Terverifikasi (Aktif)</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold text-emerald-600 mt-2">{{ $ptTerverifikasi }} PT</h3>
                <p class="text-xs text-gray-400 mt-0.5">Dapat membuka lowongan</p>
            </div>

            <!-- Card Highlight Dinonaktifkan (Down / Suspended) -->
            <div class="bg-white rounded-2xl border border-rose-200 p-5 shadow-sm ring-1 ring-rose-100">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-rose-600 uppercase tracking-wider">Dinonaktifkan (Suspended)</span>
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">block</span>
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-2">{{ $ptSuspended }} PT Bermasalah</h3>
                <p class="text-xs text-gray-500 mt-0.5">Akses dihentikan sementara</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Menunggu Verifikasi</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">hourglass_top</span>
                    </div>
                </div>
                <h3 class="text-2xl font-extrabold text-amber-600 mt-2">{{ $ptMenunggu }} Pengajuan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Perlu approval Superadmin</p>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-2xl border border-gray-200/80 p-4 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <!-- Filter Pills -->
            <div class="flex items-center gap-1.5 flex-wrap w-full md:w-auto">
                <a href="{{ route('superadmin.akun.index') }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !$statusFilter ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua PT ({{ $totalPT }})
                </a>
                <a href="{{ route('superadmin.akun.index', ['status' => 'terverifikasi']) }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'terverifikasi' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                    Aktif ({{ $ptTerverifikasi }})
                </a>
                <a href="{{ route('superadmin.akun.index', ['status' => 'suspended']) }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'suspended' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                    Dinonaktifkan / Suspend ({{ $ptSuspended }})
                </a>
                <a href="{{ route('superadmin.akun.index', ['status' => 'menunggu']) }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'menunggu' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    Menunggu ({{ $ptMenunggu }})
                </a>
                <a href="{{ route('superadmin.akun.index', ['status' => 'ditolak']) }}"
                   class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $statusFilter === 'ditolak' ? 'bg-gray-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Ditolak ({{ $ptDitolak }})
                </a>
            </div>

            <!-- Form Search -->
            <form action="{{ route('superadmin.akun.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto m-0">
                @if($statusFilter)
                    <input type="hidden" name="status" value="{{ $statusFilter }}">
                @endif
                <div class="relative flex-1 md:w-64">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama PT / email / domisili..."
                           class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <span class="material-symbols-outlined absolute left-2.5 top-2.5 text-gray-400 text-[16px]">search</span>
                </div>
                @if($search)
                    <a href="{{ route('superadmin.akun.index', ['status' => $statusFilter]) }}" class="p-2 text-gray-400 hover:text-gray-600" title="Reset cari">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Kelola Akun Mitra PT -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-gray-900">Daftar Akun Mitra Perusahaan (Admin PT)</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Kontrol status akses, nonaktifkan (suspend) PT yang bermasalah, atau aktifkan kembali</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-purple-50 text-[#6b21a8] border border-purple-200 text-xs font-bold">
                    {{ $mitraPTs->total() }} Akun PT
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50/70 text-xs font-bold text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Perusahaan & Kontak</th>
                            <th class="px-6 py-3.5">Domisili</th>
                            <th class="px-6 py-3.5">Aktivitas (Loker / Aduan)</th>
                            <th class="px-6 py-3.5">Status Akun</th>
                            <th class="px-6 py-3.5 text-right">Tindakan Superadmin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($mitraPTs as $pt)
                            <tr class="hover:bg-gray-50/60 transition align-top {{ $pt->is_suspended ? 'bg-rose-50/20' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $pt->is_suspended ? 'bg-rose-100 text-rose-700' : 'bg-purple-100 text-[#6b21a8]' }} font-extrabold text-xs flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($pt->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 block leading-tight">{{ $pt->name }}</span>
                                            <span class="text-xs text-gray-600 block">{{ $pt->email }}</span>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pt->whatsapp) }}" target="_blank"
                                               class="text-[11px] text-emerald-600 hover:underline flex items-center gap-1 font-semibold mt-0.5">
                                                <span>WA: {{ $pt->whatsapp }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-xs font-medium text-gray-700">
                                    {{ $pt->domisili ?? '-' }}
                                    <span class="block text-[11px] text-gray-400 mt-1">
                                        Bergabung: {{ $pt->created_at ? $pt->created_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-xs">
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-purple-50 text-[#6b21a8] font-bold text-[11px]">
                                            <span class="material-symbols-outlined text-[14px]">work</span>
                                            {{ $pt->pekerjaans_count ?? 0 }} Lowongan
                                        </span>
                                        @if(($pt->laporans_diterima_count ?? 0) > 0)
                                            <a href="{{ route('superadmin.laporan.index', ['search' => $pt->name]) }}"
                                               class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-red-50 text-red-700 font-bold text-[11px] hover:underline block w-fit">
                                                <span class="material-symbols-outlined text-[14px]">warning</span>
                                                {{ $pt->laporans_diterima_count }} Pengaduan Masuk
                                            </a>
                                        @else
                                            <span class="text-[11px] text-gray-400 block">0 Pengaduan Masalah</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="space-y-1.5">
                                        @if($pt->is_suspended)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-extrabold">
                                                <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                                                Dinonaktifkan (Suspended)
                                            </span>
                                            @if($pt->alasan_suspend)
                                                <div class="p-2 rounded-xl bg-rose-50 border border-rose-100 text-[11px] text-rose-900 max-w-xs">
                                                    <span class="font-bold block text-[10px] uppercase text-rose-800">Alasan Suspend:</span>
                                                    <span>{{ $pt->alasan_suspend }}</span>
                                                </div>
                                            @endif
                                        @elseif($pt->status_verifikasi_pt === 'terverifikasi')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Terverifikasi (Aktif)
                                            </span>
                                        @elseif($pt->status_verifikasi_pt === 'menunggu')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold">
                                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Verifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 border border-gray-200 text-xs font-bold">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($pt->is_suspended)
                                            <!-- Tombol Aktifkan Kembali -->
                                            <form action="{{ route('superadmin.akun.unsuspend', $pt->id) }}" method="POST" class="inline m-0"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin MENGAKTIFKAN KEMBALI akun PT {{ $pt->name }}?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 text-xs font-bold transition shadow-sm">
                                                    <span class="material-symbols-outlined text-[15px]">lock_open</span>
                                                    <span>Aktifkan Kembali</span>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Tombol Nonaktifkan (Ngedownin PT) -->
                                            <button type="button" onclick="bukaModalSuspend({{ $pt->id }}, '{{ addslashes($pt->name) }}')"
                                                    class="inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-bold transition">
                                                <span class="material-symbols-outlined text-[15px]">block</span>
                                                <span>Nonaktifkan (Suspend)</span>
                                            </button>
                                        @endif

                                        <!-- Tombol Hapus Akun -->
                                        <form action="{{ route('superadmin.akun.destroy', $pt->id) }}" method="POST" class="inline m-0"
                                              onsubmit="return confirm('PERINGATAN: Menghapus akun PT {{ $pt->name }} akan menghapus seluruh data loker dan pelamar terkait. Yakin lanjutkan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus Akun PT">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <span class="material-symbols-outlined text-[42px] text-gray-300">domain_disabled</span>
                                    <p class="text-sm font-semibold text-gray-600 mt-2">Tidak ada akun mitra PT yang cocok dengan filter saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mitraPTs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $mitraPTs->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- ================= MODAL SUSPEND / NONAKTIFKAN PT ================= -->
    <div id="modalSuspend" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-5 animate-scale-in">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">block</span>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-900" id="modalSuspendPtName">Nonaktifkan (Suspend) Akun PT</h3>
                        <p class="text-[11px] text-gray-400 font-semibold">Tutup akses login & hentikan penayangan seluruh lowongan</p>
                    </div>
                </div>
                <button type="button" onclick="tutupModalSuspend()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <div class="p-3 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-800 space-y-1">
                <p class="font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">warning</span>
                    <span>Dampak Menonaktifkan (Suspend):</span>
                </p>
                <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-700">
                    <li>Akun Admin PT tidak akan bisa login ke dashboard.</li>
                    <li>Semua lowongan aktif milik PT ini akan otomatis <strong>DITUTUP</strong> dari pelamar.</li>
                    <li>Alasan penonaktifan akan ditampilkan saat PT mencoba login.</li>
                </ul>
            </div>

            <form id="formSuspend" action="" method="POST" class="space-y-4 m-0">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Alasan Penonaktifan (Pelanggaran / Aduan) *</label>
                    <textarea name="alasan_suspend" rows="3" required
                              placeholder="Tuliskan alasan spesifik (misal: Terbukti melakukan penipuan upah pada Loker #12, Nomor kontak palsu, Tidak membayar hak pekerja, dll)..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs font-medium text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="tutupModalSuspend()"
                            class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs hover:bg-gray-200 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-rose-600 text-white font-bold text-xs hover:bg-rose-700 transition shadow-sm flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">power_settings_new</span>
                        <span>Konfirmasi Nonaktifkan PT</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal Suspend -->
    <script>
        function bukaModalSuspend(id, name) {
            const form = document.getElementById('formSuspend');
            form.action = `/admin/superadmin/akun/${id}/suspend`;
            document.getElementById('modalSuspendPtName').innerText = `Suspend Akun PT: ${name}`;
            document.getElementById('modalSuspend').classList.remove('hidden');
        }

        function tutupModalSuspend() {
            document.getElementById('modalSuspend').classList.add('hidden');
        }
    </script>

</body>

</html>

