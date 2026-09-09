@extends('admin_pt.layouts.app')

@section('header-title', 'Detail Lowongan')

@section('content')
    <div class="w-full px-6 lg:px-10 py-6">

        @php
            $lat = $lowongan->latitude ?? -6.2;
            $lng = $lowongan->longitude ?? 106.816666;
        @endphp

        <!-- 1. Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-3">
            <a href="{{ route('admin_pt.lowongan.index') }}" class="text-gray-500 hover:text-purple-700 transition">Lowongan
                Saya</a>
            <span class="text-gray-400">&gt;</span>
            <span class="font-bold text-purple-900">Detail Lowongan</span>
        </nav>

        <!-- 2. Header & Action Buttons -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl lg:text-[28px] font-extrabold text-gray-900 tracking-tight">{{ $lowongan->judul }}</h1>
                <p class="text-sm text-gray-500 mt-1">Dibuat pada
                    {{ $lowongan->created_at ? $lowongan->created_at->format('d M Y, H:i') : '-' }} WIB</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin_pt.lowongan.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </a>
                <a href="{{ route('admin_pt.lowongan.edit', $lowongan->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#7c3aed] hover:bg-[#6d28d9] text-white text-sm font-bold shadow-md shadow-purple-600/20 transition">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Edit Lowongan
                </a>
                <form action="{{ route('admin_pt.lowongan.destroy', $lowongan->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')" class="inline m-0 p-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-red-200 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-sm font-semibold transition shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- 3. Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- KOLOM KIRI: DETAIL PEKERJAAN & DAFTAR PELAMAR (7 Kolom) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- Card Detail -->
                <div
                    class="bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-gray-100 p-6 sm:p-8 space-y-6">

                    <!-- Status Badges -->
                    <div class="flex flex-wrap items-center gap-3 pb-4 border-b border-gray-100">
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">Status Loker:</span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ ($lowongan->status_loker ?? 'aktif') === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                                <span
                                    class="w-2 h-2 rounded-full {{ ($lowongan->status_loker ?? 'aktif') === 'aktif' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ ucfirst($lowongan->status_loker ?? 'Aktif') }}
                            </span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block mb-1">Status Moderasi:</span>
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ ($lowongan->status_moderasi ?? 'menunggu') === 'disetujui' ? 'bg-blue-50 text-blue-700 border border-blue-200' : (($lowongan->status_moderasi ?? 'menunggu') === 'ditolak' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}">
                                <span
                                    class="w-2 h-2 rounded-full {{ ($lowongan->status_moderasi ?? 'menunggu') === 'disetujui' ? 'bg-blue-500' : (($lowongan->status_moderasi ?? 'menunggu') === 'ditolak' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                                {{ ucfirst($lowongan->status_moderasi ?? 'Menunggu') }}
                            </span>
                        </div>
                    </div>

                    <!-- Key Metrics Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-[#f8f9fa] border border-gray-200/80 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[22px]">payments</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block">Upah / Pembayaran</span>
                                <span class="text-sm font-bold text-gray-900">Rp
                                    {{ number_format((float) $lowongan->upah, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="p-4 rounded-xl bg-[#f8f9fa] border border-gray-200/80 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-purple-100 text-[#6b21a8] flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[22px]">schedule</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-400 font-medium block">Durasi Kerja</span>
                                <span class="text-sm font-bold text-gray-900">{{ $lowongan->durasi }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Pekerjaan -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-500 text-[18px]">segment</span>
                            Rincian &amp; Deskripsi Pekerjaan
                        </h3>
                        <div
                            class="bg-[#f8f9fa] border border-gray-200/80 rounded-xl p-5 text-sm text-gray-700 leading-relaxed whitespace-pre-line font-medium">
                            {{ $lowongan->deskripsi }}
                        </div>
                    </div>

                    <!-- Titik Lokasi & Peta Utama -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-500 text-[18px]">location_on</span>
                            Titik Lokasi Kerja
                        </h3>

                        <!-- Badge Koordinat + Link Google Maps -->
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <div
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-100 text-[11px] font-mono font-semibold text-purple-700">
                                <span class="material-symbols-outlined text-[13px]">pin_drop</span>
                                LAT: {{ $lat }}
                            </div>
                            <div
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 border border-purple-100 text-[11px] font-mono font-semibold text-purple-700">
                                <span class="material-symbols-outlined text-[13px]">explore</span>
                                LNG: {{ $lng }}
                            </div>
                            <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}"
                                target="_blank"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-100 text-[11px] font-semibold text-blue-700 hover:bg-blue-100 transition">
                                <span class="material-symbols-outlined text-[13px]">open_in_new</span>
                                Buka di Google Maps
                            </a>
                        </div>

                        <!-- Peta Leaflet (Read-Only, Besar) -->
                        <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm relative">
                            <div id="map-show" class="w-full h-72 z-10"></div>
                            <div
                                class="absolute bottom-2 left-2 z-20 bg-white/95 backdrop-blur px-3 py-1.5 rounded-lg text-[11px] text-gray-600 font-medium border border-gray-200 shadow-sm pointer-events-none flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[15px] text-purple-600">location_on</span>
                                <span>Titik koordinat lokasi kerja</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Card Pelamar Masuk -->
                <div class="bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-gray-100 p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Pelamar Masuk</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Daftar kandidat pekerja yang melamar pada lowongan ini.
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 border border-purple-100 text-xs font-bold">
                                {{ $lowongan->applications ? $lowongan->applications->count() : 0 }} Pelamar
                            </span>
                            <a href="{{ route('admin_pt.pelamar.index', ['pekerjaan_id' => $lowongan->id]) }}"
                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-[#6b21a8] text-white text-xs font-bold hover:bg-[#581c87] transition shadow-sm">
                                <span>Kelola Pelamar</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm divide-y divide-gray-100">
                            <thead>
                                <tr class="text-xs font-bold text-gray-400 uppercase">
                                    <th class="pb-3">Nama Pelamar</th>
                                    <th class="pb-3">WhatsApp / Kontak</th>
                                    <th class="pb-3">Status Lamaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($lowongan->applications ?? [] as $app)
                                    <tr>
                                        <td class="py-3 font-semibold text-gray-800">{{ $app->user->name ?? 'Pelamar' }}
                                        </td>
                                        <td class="py-3 text-gray-600">{{ $app->user->whatsapp ?? '-' }}</td>
                                        <td class="py-3">
                                            <span
                                                class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                                {{ ucfirst($app->status ?? 'Menunggu') }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-8 text-center text-gray-400">
                                            <div class="flex flex-col items-center justify-center gap-1">
                                                <span
                                                    class="material-symbols-outlined text-[32px] text-gray-300">group_off</span>
                                                <span class="text-xs font-medium">Belum ada pelamar untuk lowongan
                                                    ini.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN: PRATINJAU KARTU PUBLIK + MINI MAP (5 Kolom) -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Card Pratinjau Publik -->
                <div>
                    <div class="flex items-center justify-between mb-3 px-1">
                        <span class="text-[11px] font-bold tracking-wider text-gray-500 uppercase">TAMPILAN DI APLIKASI
                            PUBLIK</span>
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-[11px] font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif Cepat
                        </span>
                    </div>

                    <div class="bg-white border border-gray-200/90 rounded-2xl p-6 shadow-sm">
                        <!-- Top Info -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-11 h-11 rounded-full bg-[#5b21b6] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'MB', 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900 leading-tight">
                                        {{ auth()->user()->name ?? 'PT Maju Bersama' }}
                                    </h4>
                                    <p class="text-[11px] text-gray-400 mt-0.5">
                                        {{ $lowongan->created_at ? $lowongan->created_at->diffForHumans() : 'Baru saja' }}
                                    </p>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-100 text-[11px] font-bold shrink-0">
                                Harian
                            </span>
                        </div>

                        <!-- Job Title -->
                        <h3 class="font-bold text-gray-900 text-base mt-4 leading-snug">{{ $lowongan->judul }}</h3>

                        <!-- Job Snippet -->
                        <p class="text-xs text-gray-500 mt-2 line-clamp-3 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($lowongan->deskripsi, 120) }}
                        </p>

                        <!-- Meta Details -->
                        <div class="mt-4 space-y-2.5 text-xs text-gray-600 border-t border-gray-100 pt-3.5">
                            <div class="flex items-center gap-2">
                                <span
                                    class="material-symbols-outlined text-[#7c3aed] text-[17px] shrink-0">location_on</span>
                                <span
                                    class="truncate font-medium text-gray-700 font-mono text-[11px]">{{ $lat }},
                                    {{ $lng }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="material-symbols-outlined text-emerald-600 text-[17px] shrink-0">payments</span>
                                <span class="font-bold text-emerald-700">Rp
                                    {{ number_format((float) $lowongan->upah, 0, ',', '.') }} / hari</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-gray-400 text-[17px] shrink-0">schedule</span>
                                <span class="truncate font-medium text-gray-600">{{ $lowongan->durasi }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mini Peta Kanan -->
                <div>
                    <div class="flex items-center justify-between mb-3 px-1">
                        <span class="text-[11px] font-bold tracking-wider text-gray-500 uppercase">PETA LOKASI</span>
                        <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}" target="_blank"
                            class="text-[11px] font-semibold text-purple-700 hover:text-purple-900 flex items-center gap-1 transition">
                            <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                            Buka Google Maps
                        </a>
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-gray-200/90 shadow-sm">
                        <div id="map-mini" class="w-full h-52 z-10"></div>
                    </div>
                    <div class="flex items-center gap-2 mt-2 px-1">
                        <span class="w-2 h-2 rounded-full bg-purple-600 shrink-0"></span>
                        <span class="text-[11px] text-gray-500 font-mono">{{ $lat }}, {{ $lng }}</span>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lat = {{ $lat }};
            const lng = {{ $lng }};

            // --- Peta Utama (Kiri, Besar) dengan Popup ---
            const mapShow = L.map('map-show', {
                zoomControl: true,
                scrollWheelZoom: false
            }).setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(mapShow);

            const markerShow = L.marker([lat, lng]).addTo(mapShow);
            markerShow.bindPopup(
                `<div style="font-size:12px; min-width:170px; line-height:1.5;">
                <b style="color:#4c1d95;">{{ addslashes($lowongan->judul) }}</b><br>
                <span style="color:#6b7280; font-size:11px;">{{ addslashes($lowongan->durasi ?? '-') }}</span><br>
                <span style="color:#059669; font-weight:700;">Rp {{ number_format((float) $lowongan->upah, 0, ',', '.') }}</span>
             </div>`
            ).openPopup();

            // --- Peta Mini (Kanan, Kecil, Non-interaktif) ---
            const mapMini = L.map('map-mini', {
                zoomControl: false,
                scrollWheelZoom: false,
                dragging: false,
                doubleClickZoom: false,
                touchZoom: false
            }).setView([lat, lng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(mapMini);

            L.marker([lat, lng]).addTo(mapMini);
        });
    </script>
@endpush
