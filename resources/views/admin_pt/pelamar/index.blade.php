@extends('admin_pt.layouts.app')

@section('header-title', $isRiwayat ? 'Riwayat Pelamar' : 'Manajemen Pelamar Masuk')

@section('content')
    <div class="w-full px-6 lg:px-10 py-8 max-w-7xl mx-auto space-y-6">

        <!-- Flash Messages & Notifikasi WhatsApp -->
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[22px] text-emerald-600 shrink-0">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                @if (session('open_wa'))
                    <a href="{{ session('open_wa') }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.177.182-.076.355.101.173.449.741.963 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/>
                        </svg>
                        Buka WhatsApp Sekarang
                    </a>
                @endif
            </div>
        @endif

        @if ($allLowongans->isEmpty())
            <!-- Tampilan Kosong Jika PT Belum Punya Lowongan -->
            <div class="bg-white rounded-3xl border border-gray-200/80 p-12 text-center shadow-sm max-w-2xl mx-auto my-12">
                <div class="w-16 h-16 rounded-2xl bg-[#ede9fe] text-[#6b21a8] flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-[36px]">work_outline</span>
                </div>
                <h2 class="text-xl font-extrabold text-gray-900">Belum Ada Lowongan Pekerjaan</h2>
                <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">
                    Perusahaan Anda belum memposting lowongan kerja. Buat lowongan terlebih dahulu agar pelamar dapat melihat posisi yang dibuka dan mulai mendaftar.
                </p>
                <div class="mt-6">
                    <a href="{{ route('admin_pt.lowongan.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#6b21a8] text-white text-sm font-bold shadow hover:bg-[#581c87] transition">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Buat Lowongan Pertama
                    </a>
                </div>
            </div>
        @else
            <!-- TOP BAR: Header Lowongan & Filter Kriteria -->
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                <!-- Kolom Kiri: Breadcrumb / ID Req + Judul Lowongan + Subtitle -->
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                        <span class="text-[11px] font-extrabold tracking-wider text-gray-500 uppercase">
                            {{ $isRiwayat ? 'RIWAYAT PELAMAR MASUK' : 'MANAJEMEN PELAMAR MASUK' }} • ID REQ: #KSL-{{ str_pad($selectedLowongan->id ?? 1, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                        <span>Pelamar — {{ $selectedLowongan->judul ?? 'Lowongan Pekerjaan' }}</span>
                    </h1>

                    <p class="text-xs sm:text-sm text-gray-500 mt-1.5 max-w-3xl leading-relaxed">
                        Total <strong class="text-gray-800 font-semibold">{{ $totalPelamar }} pelamar siap kerja</strong> • Disortir otomatis berdasarkan skor kecocokan profil, kesiapan fisik, dan kedekatan radius lokasi.
                    </p>
                </div>

                <!-- Kolom Kanan: Status Badges & Filter Kriteria / Pilih Lowongan -->
                <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-center">
                    <!-- Badge Lowongan Aktif -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-sm">
                        <span class="material-symbols-outlined text-emerald-600 text-[16px] font-bold">check_circle</span>
                        <span>{{ ucfirst($selectedLowongan->status_loker ?? 'aktif') === 'Aktif' ? 'Lowongan Aktif' : 'Lowongan Ditutup' }}</span>
                    </div>

                    <!-- Badge Shift / Durasi -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-50 border border-gray-200 text-xs font-semibold text-gray-600">
                        <span>{{ $selectedLowongan->durasi ?? 'Shift Harian' }}</span>
                    </div>

                    <!-- Dropdown Filter Kriteria & Switch Lowongan -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button"
                                onclick="document.getElementById('dropdown-filter').classList.toggle('hidden')"
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                            <span class="material-symbols-outlined text-[18px] text-gray-500">tune</span>
                            <span>Filter Kriteria</span>
                            <span class="material-symbols-outlined text-[16px] text-gray-400">expand_more</span>
                        </button>

                        <!-- Dropdown Content -->
                        <div id="dropdown-filter"
                             class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 p-4 z-50">
                            <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Lowongan</span>
                            <div class="space-y-1 mb-4 max-h-40 overflow-y-auto">
                                @foreach ($allLowongans as $itemLoker)
                                    <a href="{{ request()->fullUrlWithQuery(['pekerjaan_id' => $itemLoker->id]) }}"
                                       class="block px-3 py-2 rounded-xl text-xs font-medium transition {{ ($selectedLowongan->id ?? null) == $itemLoker->id ? 'bg-[#ede9fe] text-[#6b21a8] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                        {{ $itemLoker->judul }}
                                    </a>
                                @endforeach
                            </div>

                            <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Filter Status</span>
                            <div class="flex flex-wrap gap-1.5">
                                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
                                   class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ empty($statusFilter) ? 'bg-[#6b21a8] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    Semua
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'menunggu']) }}"
                                   class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusFilter === 'menunggu' ? 'bg-[#6b21a8] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    Menunggu
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'diterima']) }}"
                                   class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusFilter === 'diterima' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    Diterima
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['status' => 'ditolak']) }}"
                                   class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusFilter === 'ditolak' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                    Ditolak
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4 QUICK INDICATOR PILLS ROW -->
            <div class="bg-white rounded-2xl border border-gray-200/80 px-6 py-3.5 shadow-sm">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                    
                    <!-- Indikator 1: Respon Cepat -->
                    <div class="flex items-center gap-2.5 pt-2 md:pt-0">
                        <span class="material-symbols-outlined text-[#7c3aed] text-[20px]">bolt</span>
                        <span class="text-xs font-bold text-gray-800">
                            Respon Cepat: <span class="font-normal text-gray-600">&lt; 15 Menit</span>
                        </span>
                    </div>

                    <!-- Indikator 2: Verifikasi KTP -->
                    <div class="flex items-center gap-2.5 pt-2 md:pt-0 md:pl-6">
                        <span class="material-symbols-outlined text-emerald-600 text-[20px]">verified</span>
                        <span class="text-xs font-bold text-gray-800">
                            Verifikasi KTP: <span class="font-normal text-gray-600">100% Valid</span>
                        </span>
                    </div>

                    <!-- Indikator 3: Radius Rata-rata -->
                    <div class="flex items-center gap-2.5 pt-2 md:pt-0 md:pl-6">
                        <span class="material-symbols-outlined text-gray-500 text-[20px]">near_me</span>
                        <span class="text-xs font-bold text-gray-800">
                            Radius Rata-rata: <span class="font-normal text-gray-600">3.7 km</span>
                        </span>
                    </div>

                    <!-- Indikator 4: Kebutuhan Terpenuhi -->
                    <div class="flex items-center gap-2.5 pt-2 md:pt-0 md:pl-6">
                        <span class="material-symbols-outlined text-[#7c3aed] text-[20px]">build</span>
                        <span class="text-xs font-bold text-gray-800">
                            Kebutuhan: <span class="font-bold text-[#6b21a8]">{{ $diterimaCount }} / {{ $targetKebutuhan }} Terpenuhi</span>
                        </span>
                    </div>

                </div>
            </div>

            <!-- MAIN CARD: DAFTAR PELAMAR PRIORITAS -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
                
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <!-- Sisi Kiri: Judul Kolom Pelamar -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs font-extrabold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[18px] text-gray-400">badge</span>
                        <span>DAFTAR PELAMAR PRIORITAS</span>
                    </div>

                    <!-- Sisi Kanan: Header Kompatibilitas & Aksi -->
                    <div class="hidden md:flex items-center gap-16 text-gray-500 text-xs font-extrabold uppercase tracking-wider pr-4">
                        <span class="w-40 text-center">TINGKAT KOMPATIBILITAS</span>
                        <span class="w-36 text-center">AKSI KEPUTUSAN</span>
                    </div>
                </div>

                <!-- List Pelamar -->
                <div class="divide-y divide-gray-100">
                    @forelse ($pelamars as $pelamar)
                        @php
                            $avatarPalette = $pelamar->avatar_color;
                            $kualifikasi = $pelamar->kualifikasi_tag;
                            $score = $pelamar->kompatibilitas_score;
                        @endphp

                        <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-gray-50/60 transition-all">
                            
                            <!-- Sisi Kiri: Avatar + Nama + Tag + Info Detail Jarak -->
                            <div class="flex items-center gap-4 min-w-0">
                                <!-- Avatar Inisial Bulat -->
                                <div class="relative shrink-0">
                                    <div class="w-12 h-12 rounded-full {{ $avatarPalette['bg'] }} {{ $avatarPalette['text'] }} font-extrabold text-sm flex items-center justify-center shadow-inner tracking-wider">
                                        {{ $pelamar->inisial }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                </div>

                                <!-- Detail Pelamar -->
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-bold text-gray-900 text-sm sm:text-base leading-tight">
                                            {{ $pelamar->user->name ?? 'Kandidat Pekerja' }}
                                        </span>

                                        <!-- Tag Kualifikasi / Rating -->
                                        @if ($kualifikasi['type'] === 'rating')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700 text-[11px] font-semibold">
                                                <span class="material-symbols-outlined text-[14px] text-amber-500 fill-1">star</span>
                                                {{ $kualifikasi['label'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700 text-[11px] font-semibold">
                                                @if(isset($kualifikasi['icon']))
                                                    <span class="material-symbols-outlined text-[14px] text-gray-500">{{ $kualifikasi['icon'] }}</span>
                                                @endif
                                                {{ $kualifikasi['label'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Ringkasan Pengalaman & Radius Jarak -->
                                    <p class="text-xs text-gray-500 mt-1 truncate">
                                        {{ $pelamar->deskripsi_pelamar }}
                                    </p>
                                </div>
                            </div>

                            <!-- Sisi Kanan: Skor Kompatibilitas + Tombol Keputusan (Tolak / Terima) -->
                            <div class="flex items-center justify-between md:justify-end gap-6 shrink-0 pt-2 md:pt-0">
                                
                                <!-- Tingkat Kompatibilitas Badge -->
                                <div class="w-auto md:w-40 flex justify-start md:justify-center">
                                    @if ($score >= 80)
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 font-extrabold text-xs border border-emerald-200/80">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                            {{ $score }}% Cocok
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-50 text-amber-800 font-extrabold text-xs border border-amber-200/80">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 inline-block"></span>
                                            {{ $score }}% Cocok
                                        </span>
                                    @endif
                                </div>

                                <!-- Aksi Keputusan -->
                                <div class="w-auto md:w-36 flex items-center justify-end gap-2">
                                    @if ($pelamar->status === 'menunggu')
                                        <!-- Tombol Tolak -->
                                        <form action="{{ route('admin_pt.pelamar.update_status', $pelamar->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menolak pelamar ini?')"
                                                    class="px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:bg-gray-100 text-xs font-bold transition shadow-sm">
                                                Tolak
                                            </button>
                                        </form>

                                        <!-- Tombol Terima (Terhubung WhatsApp) -->
                                        <form action="{{ route('admin_pt.pelamar.update_status', $pelamar->id) }}" method="POST" class="inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="diterima">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#6b21a8] text-white hover:bg-[#581c87] text-xs font-bold shadow-sm transition">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                                </svg>
                                                Terima
                                            </button>
                                        </form>
                                    @elseif ($pelamar->status === 'diterima')
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                                                Diterima
                                            </span>
                                            <a href="{{ $pelamar->whatsapp_link }}" target="_blank" title="Hubungi WhatsApp"
                                               class="p-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.177.182-.076.355.101.173.449.741.963 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 text-xs font-semibold">
                                            Ditolak
                                        </span>
                                    @endif
                                </div>

                            </div>

                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-400">
                            <span class="material-symbols-outlined text-[48px] text-gray-300">group_off</span>
                            <p class="text-sm font-semibold text-gray-600 mt-2">Belum ada pelamar untuk lowongan ini.</p>
                            <p class="text-xs text-gray-400 mt-1">Kandidat pelamar yang mendaftar ke posisi ini akan otomatis ditampilkan di sini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- CARD FOOTER: PAGINATION INFO & CONTROLS -->
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <span class="text-xs text-gray-500 font-medium">
                        Menampilkan <strong class="text-gray-800 font-bold">{{ $pelamars->firstItem() ?? 0 }} - {{ $pelamars->lastItem() ?? 0 }}</strong> dari <strong class="text-gray-800 font-bold">{{ $pelamars->total() }}</strong> pelamar
                    </span>

                    <!-- Numbered Pagination -->
                    @if ($pelamars->hasPages())
                        <div class="flex items-center gap-1.5 self-center sm:self-auto">
                            {{-- Previous Button --}}
                            @if ($pelamars->onFirstPage())
                                <span class="w-8 h-8 rounded-full text-gray-300 flex items-center justify-center cursor-not-allowed text-sm">
                                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                </span>
                            @else
                                <a href="{{ $pelamars->previousPageUrl() }}" class="w-8 h-8 rounded-full text-gray-600 hover:bg-gray-100 flex items-center justify-center text-sm transition">
                                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($pelamars->getUrlRange(1, $pelamars->lastPage()) as $page => $url)
                                @if ($page == $pelamars->currentPage())
                                    <span class="w-8 h-8 rounded-full bg-[#6b21a8] text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="w-8 h-8 rounded-full text-gray-600 hover:bg-gray-100 font-medium flex items-center justify-center text-xs transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Button --}}
                            @if ($pelamars->hasMorePages())
                                <a href="{{ $pelamars->nextPageUrl() }}" class="w-8 h-8 rounded-full text-gray-600 hover:bg-gray-100 flex items-center justify-center text-sm transition">
                                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                </a>
                            @else
                                <span class="w-8 h-8 rounded-full text-gray-300 flex items-center justify-center cursor-not-allowed text-sm">
                                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

            </div>

            <!-- OPERATIONAL NOTE BANNER (PURPLE BOTTOM CARD) -->
            <div class="bg-[#f5f3ff] border border-purple-100 rounded-2xl p-5 flex items-start gap-3.5 shadow-sm">
                <span class="material-symbols-outlined text-[#7c3aed] text-[22px] shrink-0 mt-0.5">info</span>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed">
                    <strong class="font-extrabold text-gray-900">Catatan Operasional:</strong>
                    Klik <span class="font-bold text-[#6b21a8]">"Terima"</span> akan langsung membuka ruang obrolan WhatsApp ke nomor pelamar untuk instruksi penjemputan, perlengkapan APD kerja, serta validasi kehadiran harian.
                </p>
            </div>
        @endif

    </div>

    {{-- Script jika ada sesi otomatis membuka WA saat pelamar baru saja diterima --}}
    @if (session('open_wa'))
        @push('scripts')
            <script>
                // Membuka tautan WhatsApp pelamar di tab baru secara otomatis
                window.open("{{ session('open_wa') }}", "_blank");
            </script>
        @endpush
    @endif
@endsection
