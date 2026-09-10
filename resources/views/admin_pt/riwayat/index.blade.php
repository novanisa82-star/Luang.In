@extends('admin_pt.layouts.app')

@section('header-title', 'Riwayat Pelamar Diterima')

@section('content')
    <div class="w-full px-6 lg:px-10 py-8 max-w-7xl mx-auto space-y-6">

        <!-- TOP BAR: Header & Filter/Cari/Ekspor -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Sisi Kiri: Breadcrumb / Label + Judul + Subtitle -->
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#ede9fe] text-[#6b21a8]">
                        <span class="material-symbols-outlined text-[14px]">task_alt</span>
                    </span>
                    <span class="text-[11px] font-extrabold tracking-wider text-gray-500 uppercase">
                        ARSIP REKRUTMEN LAPANGAN
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Riwayat Pelamar Diterima
                </h1>

                <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl leading-relaxed">
                    Daftar tenaga kerja serabutan yang telah disetujui dan dihubungi untuk penugasan aktif.
                </p>
            </div>

            <!-- Sisi Kanan: Search Bar, Dropdown Bulan, Tombol Ekspor -->
            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Input Pencarian -->
                <form action="{{ route('admin_pt.riwayat.index') }}" method="GET" class="relative m-0">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">
                        search
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama atau pekerjaan..."
                           class="w-56 sm:w-64 pl-9 pr-3.5 py-2 rounded-xl bg-white border border-gray-200 text-xs text-gray-700 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                </form>

                <!-- Filter Bulan -->
                <div class="relative">
                    <button type="button"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                        <span class="material-symbols-outlined text-gray-500 text-[16px]">calendar_month</span>
                        <span>Bulan Ini</span>
                        <span class="material-symbols-outlined text-gray-400 text-[16px]">expand_more</span>
                    </button>
                </div>

                <!-- Tombol Ekspor -->
                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                    <span class="material-symbols-outlined text-gray-600 text-[16px]">file_download</span>
                    <span>Ekspor</span>
                </button>
            </div>
        </div>

        <!-- 3 METRIC CARDS ROW -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <!-- Card 1: Total Pekerja Terpilih -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500">Total Pekerja Terpilih</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                        {{ $totalTerpilih }} Orang
                    </h3>
                    <div class="mt-2 text-xs font-medium text-emerald-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px]">trending_up</span>
                        <span>+{{ $pekerjaMingguIni }} pekerja minggu ini</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-[#ede9fe] text-[#6b21a8] flex items-center justify-center shrink-0 shadow-inner">
                    <span class="material-symbols-outlined text-[24px]">assignment_turned_in</span>
                </div>
            </div>

            <!-- Card 2: Tingkat Hadir Kerja -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500">Tingkat Hadir Kerja</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                        {{ $tingkatHadir }}
                    </h3>
                    <div class="mt-2 text-xs font-medium text-gray-500 flex items-center gap-1">
                        <span class="material-symbols-outlined text-emerald-600 text-[15px]">check_circle</span>
                        <span>Sesuai jadwal kedatangan</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 shadow-inner">
                    <span class="material-symbols-outlined text-[24px]">schedule</span>
                </div>
            </div>

            <!-- Card 3: Kesiapan WhatsApp -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500">Kesiapan WhatsApp</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                        {{ $kesiapanWa }}
                    </h3>
                    <div class="mt-2 text-xs font-medium text-gray-500 flex items-center gap-1">
                        <span class="material-symbols-outlined text-purple-600 text-[15px]">chat</span>
                        <span>Kanal koordinasi siap</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-[#7c3aed] flex items-center justify-center shrink-0 shadow-inner">
                    <span class="material-symbols-outlined text-[24px]">forum</span>
                </div>
            </div>

        </div>

        <!-- MAIN CARD: TABEL RIWAYAT KONTAK & KONFIRMASI -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
            
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h2 class="text-sm font-extrabold text-gray-800">
                        Riwayat Kontak & Konfirmasi
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-[#ede9fe] text-[#6b21a8] text-xs font-bold">
                        {{ $pelamars->count() }} Ditampilkan
                    </span>
                </div>

                <div class="flex items-center gap-1.5 text-xs font-medium text-gray-500">
                    <span>Sinkronisasi Realtime</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                </div>
            </div>

            <!-- List Rows -->
            <div class="divide-y divide-gray-100">
                @forelse ($pelamars as $item)
                    @php
                        $avatarPalette = $item->avatar_color;
                    @endphp

                    <div class="p-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 hover:bg-gray-50/60 transition-all">
                        
                        <!-- Kolom 1: Profil & WhatsApp Pelamar -->
                        <div class="flex items-center gap-4 min-w-[220px]">
                            <!-- Avatar Inisial -->
                            <div class="w-12 h-12 rounded-full {{ $avatarPalette['bg'] }} {{ $avatarPalette['text'] }} font-extrabold text-sm flex items-center justify-center shadow-inner tracking-wider shrink-0">
                                {{ $item->inisial }}
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 text-sm sm:text-base leading-tight">
                                    {{ $item->user->name ?? 'Pekerja Lapangan' }}
                                </h4>
                                <a href="{{ $item->whatsapp_link }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-emerald-700 transition mt-1 font-medium">
                                    <svg class="w-3.5 h-3.5 fill-emerald-600" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.177.182-.076.355.101.173.449.741.963 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/>
                                    </svg>
                                    <span>{{ $item->user->whatsapp ?? '+62 812-xxxx-xxxx' }}</span>
                                </a>
                            </div>
                        </div>

                        <!-- Kolom 2: Pekerjaan & Lokasi -->
                        <div class="min-w-[240px] max-w-xs">
                            <h4 class="font-bold text-gray-900 text-sm leading-tight">
                                {{ $item->pekerjaan->judul ?? 'Pekerjaan Serabutan' }}
                            </h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-[11px] font-semibold">
                                    {{ $item->pekerjaan->durasi ?? 'Logistik & Operasional' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] text-gray-400">location_on</span>
                                <span class="truncate">{{ $item->user->domisili ?? 'Lokasi Penugasan PT' }}</span>
                            </p>
                        </div>

                        <!-- Kolom 3: Waktu Diterima -->
                        <div class="flex items-start gap-2.5 min-w-[170px] text-xs text-gray-600">
                            <span class="material-symbols-outlined text-gray-400 text-[18px] shrink-0 mt-0.5">calendar_today</span>
                            <div>
                                <span class="font-semibold text-gray-800 block">
                                    Diterima: {{ $item->updated_at ? $item->updated_at->translatedFormat('d M Y') : 'Hari ini' }}
                                </span>
                                <span class="text-gray-400 text-[11px] block mt-0.5">
                                    Pukul {{ $item->updated_at ? $item->updated_at->format('H:i') : '10:00' }} WIB
                                </span>
                            </div>
                        </div>

                        <!-- Kolom 4: Badge Status Diterima -->
                        <div class="shrink-0">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 text-xs font-extrabold shadow-sm">
                                <span class="material-symbols-outlined text-[16px] font-bold">check_circle</span>
                                <span>Diterima</span>
                            </span>
                        </div>

                        <!-- Kolom 5: Aksi Menu / WhatsApp Link -->
                        <div class="flex items-center justify-end gap-2 shrink-0">
                            <a href="{{ $item->whatsapp_link }}" target="_blank"
                               title="Hubungi WhatsApp"
                               class="p-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.299.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.087.087-.177.182-.076.355.101.173.449.741.963 1.201.662.591 1.221.774 1.394.86.173.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/>
                                </svg>
                            </a>

                            @if($item->pekerjaan_id)
                                <a href="{{ route('admin_pt.lowongan.show', $item->pekerjaan_id) }}"
                                   title="Lihat Detail Lowongan"
                                   class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="p-16 text-center text-gray-400">
                        <span class="material-symbols-outlined text-[52px] text-gray-300">history_toggle_off</span>
                        <h4 class="text-sm font-bold text-gray-700 mt-3">Belum Ada Riwayat Pelamar Diterima</h4>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto leading-relaxed">
                            Pelamar yang Anda setujui pada menu <strong class="text-purple-700">Pelamar</strong> akan otomatis tercatat dan tersimpan di dalam arsip riwayat ini.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- CARD FOOTER: PAGINASI -->
            <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <span class="text-xs text-gray-500 font-medium">
                    Menampilkan <strong class="text-gray-800 font-bold">{{ $pelamars->firstItem() ?? 0 }} - {{ $pelamars->lastItem() ?? 0 }}</strong> dari <strong class="text-gray-800 font-bold">{{ $pelamars->total() }}</strong> riwayat pelamar diterima
                </span>

                <!-- Controls Paginasi Sesuai Desain -->
                @if ($pelamars->hasPages())
                    <div class="flex items-center gap-2 self-center sm:self-auto">
                        {{-- Previous Button --}}
                        @if ($pelamars->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg text-gray-300 text-xs font-semibold cursor-not-allowed flex items-center gap-1">
                                &lt; Sebelumnya
                            </span>
                        @else
                            <a href="{{ $pelamars->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 text-xs font-semibold flex items-center gap-1 transition">
                                &lt; Sebelumnya
                            </a>
                        @endif

                        {{-- Numbered Page Buttons --}}
                        <div class="flex items-center gap-1">
                            @foreach ($pelamars->getUrlRange(1, $pelamars->lastPage()) as $page => $url)
                                @if ($page == $pelamars->currentPage())
                                    <span class="w-8 h-8 rounded-lg bg-[#6b21a8] text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="w-8 h-8 rounded-lg text-gray-600 hover:bg-gray-100 font-medium flex items-center justify-center text-xs transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Button --}}
                        @if ($pelamars->hasMorePages())
                            <a href="{{ $pelamars->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 text-xs font-semibold flex items-center gap-1 transition">
                                Berikutnya &gt;
                            </a>
                        @else
                            <span class="px-3 py-1.5 rounded-lg text-gray-300 text-xs font-semibold cursor-not-allowed flex items-center gap-1">
                                Berikutnya &gt;
                            </span>
                        @endif
                    </div>
                @endif
            </div>

        </div>

        <!-- PROTOKOL PEMANGGILAN LAPANGAN (PURPLE BOTTOM BANNER) -->
        <div class="bg-[#f5f3ff] border border-purple-100 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-[#6b21a8] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[20px]">fact_check</span>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm leading-tight">
                        Protokol Pemanggilan Lapangan
                    </h4>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                        Pastikan setiap calon pekerja telah mengonfirmasi jam keberangkatan via WhatsApp resmi paling lambat 2 jam sebelum shift kerja dimulai.
                    </p>
                </div>
            </div>

            <button type="button"
                    onclick="alert('SOP Penugasan: Hubungi pekerja via WA resmi, berikan detail titik temu & perlengkapan kerja sebelum shift dimulai.')"
                    class="px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 text-xs font-bold hover:bg-gray-50 shadow-sm transition whitespace-nowrap self-start sm:self-center">
                Panduan SOP
            </button>
        </div>

    </div>
@endsection

