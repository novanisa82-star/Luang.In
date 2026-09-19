@extends('admin_pt.layouts.app')

@section('header-title', 'Rating & Ulasan Per Lowongan')

@section('content')
    <div class="w-full px-6 lg:px-10 py-8 max-w-7xl mx-auto space-y-8">

        <!-- TOP BAR: Header & Subtitle -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100 text-amber-600">
                        <span class="material-symbols-outlined text-[14px]">star</span>
                    </span>
                    <span class="text-[11px] font-extrabold tracking-wider text-gray-500 uppercase">
                        PENILAIAN PER LOWONGAN
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Rating & Ulasan Per Lowongan
                </h1>

                <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl leading-relaxed">
                    Lihat performa dan tingkat kepuasan pelamar pada masing-masing posisi pekerjaan serabutan yang Anda buka.
                </p>
            </div>

            <!-- Filter Bar: Lowongan, Bintang, Search -->
            <div class="flex flex-wrap items-center gap-2.5">
                <form action="{{ route('admin_pt.rating.index') }}" method="GET" class="flex flex-wrap items-center gap-2 m-0">
                    
                    <!-- Filter Pilih Lowongan -->
                    <select name="pekerjaan_id" onchange="this.form.submit()"
                            class="px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-500">
                        <option value="">Semua Lowongan ({{ $lowongans->count() }})</option>
                        @foreach($lowongans as $loker)
                            <option value="{{ $loker->id }}" {{ request('pekerjaan_id') == $loker->id ? 'selected' : '' }}>
                                {{ $loker->judul }} ({{ $loker->ratings->count() }} ulasan - {{ $loker->rating_rata_rata ? $loker->rating_rata_rata . '★' : 'Belum ada' }})
                            </option>
                        @endforeach
                    </select>

                    <!-- Filter Bintang -->
                    <select name="bintang" onchange="this.form.submit()"
                            class="px-3 py-2 rounded-xl bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-500">
                        <option value="">Semua Bintang</option>
                        <option value="5" {{ request('bintang') == '5' ? 'selected' : '' }}>5 Bintang ★★★★★</option>
                        <option value="4" {{ request('bintang') == '4' ? 'selected' : '' }}>4 Bintang ★★★★</option>
                        <option value="3" {{ request('bintang') == '3' ? 'selected' : '' }}>3 Bintang ★★★</option>
                        <option value="2" {{ request('bintang') == '2' ? 'selected' : '' }}>2 Bintang ★★</option>
                        <option value="1" {{ request('bintang') == '1' ? 'selected' : '' }}>1 Bintang ★</option>
                    </select>

                    <!-- Input Search -->
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">
                            search
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari ulasan..."
                               class="w-44 sm:w-56 pl-9 pr-3.5 py-2 rounded-xl bg-white border border-gray-200 text-xs text-gray-700 placeholder-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-200 focus:border-amber-500 transition">
                    </div>

                    @if(request('pekerjaan_id') || request('bintang') || request('search'))
                        <a href="{{ route('admin_pt.rating.index') }}"
                           class="px-3 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-gray-600 transition">
                            Reset Filter
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- REKAPITULASI RATING KARTU PER LOWONGAN -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-wider">
                    Ringkasan Rating Per Posisi Pekerjaan
                </h3>
                <span class="text-xs text-gray-500 font-medium">
                    Total {{ $lowongans->count() }} Lowongan
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse($lowonganRatingSummaries as $item)
                    @php
                        $loker = $item['lowongan'];
                        $avg = $item['avg'];
                        $count = $item['count'];
                        $isSelected = request('pekerjaan_id') == $loker->id;
                    @endphp
                    <div class="bg-white rounded-2xl border {{ $isSelected ? 'border-amber-400 ring-2 ring-amber-100' : 'border-gray-200/80' }} p-5 shadow-sm hover:border-amber-300 transition flex flex-col justify-between space-y-4">
                        
                        <div>
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $loker->status_loker === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $loker->status_loker === 'aktif' ? 'Loker Aktif' : 'Ditutup' }}
                                    </span>
                                    <h4 class="font-bold text-gray-900 text-sm sm:text-base mt-1.5 line-clamp-1">
                                        {{ $loker->judul }}
                                    </h4>
                                </div>

                                <div class="shrink-0 text-right">
                                    @if($count > 0)
                                        <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 font-extrabold text-sm">
                                            <span>{{ number_format($avg, 1) }}</span>
                                            <span class="text-amber-500">★</span>
                                        </div>
                                    @else
                                        <span class="px-2.5 py-1 rounded-xl bg-gray-100 text-gray-400 text-xs font-semibold">
                                            Belum Ada Rating
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                Rp {{ number_format((float)$loker->upah, 0, ',', '.') }} / {{ $loker->durasi }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium">
                                {{ $count > 0 ? "{$count} Ulasan Pelamar" : 'Belum dinilai' }}
                            </span>

                            <a href="{{ route('admin_pt.rating.index', ['pekerjaan_id' => $loker->id]) }}"
                               class="text-amber-700 font-bold hover:underline flex items-center gap-1">
                                <span>Lihat Ulasan</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full p-8 text-center bg-white rounded-2xl border border-gray-200 text-gray-400">
                        Belum ada lowongan pekerjaan yang dibuat.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- DAFTAR ULASAN MASUK (TERFILTER/SEMUA) -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <h2 class="text-sm font-extrabold text-gray-800">
                        {{ $selectedLowongan ? "Ulasan Untuk: {$selectedLowongan->judul}" : 'Daftar Semua Ulasan Pelamar' }}
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200/60">
                        {{ $ratings->total() }} Ulasan
                    </span>
                </div>

                @if($selectedLowongan)
                    <a href="{{ route('admin_pt.rating.index') }}" class="text-xs text-amber-700 font-bold hover:underline">
                        Tampilkan Semua Lowongan
                    </a>
                @endif
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($ratings as $item)
                    <div class="p-6 flex flex-col md:flex-row md:items-start justify-between gap-5 hover:bg-gray-50/60 transition-all">

                        <!-- Profil Pelamar Reviewer & Pekerjaan -->
                        <div class="flex items-start gap-4 min-w-[240px]">
                            <div class="w-11 h-11 rounded-full bg-amber-100 text-amber-800 font-extrabold text-sm flex items-center justify-center shrink-0 shadow-inner">
                                {{ strtoupper(substr($item->reviewer->name ?? 'P', 0, 2)) }}
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">
                                    {{ $item->reviewer->name ?? 'Pelamar Lapangan' }}
                                </h4>
                                <a href="{{ route('admin_pt.lowongan.show', $item->pekerjaan_id) }}"
                                   class="text-xs text-purple-700 font-bold hover:underline block mt-0.5">
                                    {{ $item->pekerjaan->judul ?? 'Lowongan Pekerjaan' }}
                                </a>
                                <span class="text-[11px] text-gray-400 block mt-1">
                                    {{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                </span>
                            </div>
                        </div>

                        <!-- Bintang & Komentar Ulasan -->
                        <div class="flex-1 bg-gray-50/80 p-4 rounded-xl border border-gray-100 space-y-2">
                            <div class="flex items-center gap-2">
                                <div class="flex items-center text-amber-400 text-sm">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="{{ $s <= $item->bintang ? 'text-amber-400' : 'text-gray-200' }}">★</span>
                                    @endfor
                                </div>
                                <span class="text-xs font-bold text-gray-800">{{ $item->bintang }}.0 / 5.0</span>
                            </div>

                            <p class="text-xs text-gray-700 leading-relaxed italic">
                                "{{ $item->komentar ?: 'Tidak ada ulasan tertulis.' }}"
                            </p>
                        </div>

                        <!-- Aksi Link -->
                        @if($item->pekerjaan_id)
                            <div class="shrink-0 self-center md:self-start">
                                <a href="{{ route('admin_pt.lowongan.show', $item->pekerjaan_id) }}"
                                   class="px-3 py-1.5 rounded-xl bg-white border border-gray-200 text-xs font-semibold text-gray-700 hover:bg-gray-50 shadow-sm transition inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-gray-500">visibility</span>
                                    <span>Lihat Loker</span>
                                </a>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="p-16 text-center text-gray-400">
                        <span class="material-symbols-outlined text-[52px] text-gray-300">reviews</span>
                        <h4 class="text-sm font-bold text-gray-700 mt-3">Belum Ada Ulasan Pada Lowongan Ini</h4>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto leading-relaxed">
                            Pelamar yang telah diterima pada posisi ini dapat memberikan rating dan ulasan setelah penugasan.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- PAGINASI -->
            @if($ratings->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500">
                        Menampilkan {{ $ratings->firstItem() }} - {{ $ratings->lastItem() }} dari {{ $ratings->total() }} ulasan
                    </span>
                    <div>
                        {{ $ratings->links() }}
                    </div>
                </div>
            @endif

        </div>

    </div>
@endsection
