@extends('admin_pt.layouts.app')

@section('header-title', 'Posting Lowongan Kerja Serabutan')

@section('content')
<div class="w-full px-6 lg:px-10 py-6">
    
    <!-- 1. Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-3">
        <a href="{{ route('admin_pt.lowongan.index') }}" class="text-gray-500 hover:text-purple-700 transition">Lowongan Saya</a>
        <span class="text-gray-400">&gt;</span>
        <span class="font-bold text-purple-900">Buat Baru</span>
    </nav>

    <!-- 2. Header & Status Estimasi -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl lg:text-[28px] font-extrabold text-gray-900 tracking-tight">Posting Lowongan Kerja Serabutan</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi detail pekerjaan untuk menemukan pekerja serabutan lokal terbaik di wilayah Anda</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-medium text-gray-700 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Estimasi Verifikasi: <span class="font-semibold text-gray-900">Instan</span>
            </span>
        </div>
    </div>

    <!-- 3. Grid 2 Kolom (Formulir & Pratinjau/Tips) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- KOLOM KIRI: FORMULIR INPUT (7 Kolom) -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-gray-100 p-6 sm:p-8">
                
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                        <p class="font-semibold mb-1">Periksa kembali data formulir:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin_pt.lowongan.store') }}" method="POST" id="form-lowongan" class="space-y-6">
                    @csrf

                    <!-- 1. Judul Lowongan -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="input-judul" class="text-sm font-bold text-gray-800">
                                Judul Lowongan <span class="text-red-500">*</span>
                            </label>
                            <span class="text-xs text-gray-400">Maks. 80 karakter</span>
                        </div>
                        <div class="bg-[#f8f9fa] border border-gray-200/90 rounded-xl px-4 py-3 flex items-center gap-3 focus-within:bg-white focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition">
                            <span class="material-symbols-outlined text-gray-400 text-[20px]">description</span>
                            <input type="text" id="input-judul" name="judul" maxlength="80" required
                                value="{{ old('judul') }}"
                                placeholder="contoh: Tukang Angkut Barang Pindahan Kantor"
                                class="w-full bg-transparent text-sm text-gray-800 focus:outline-none placeholder:text-gray-400 font-medium">
                        </div>
                    </div>

                    <!-- 2. Deskripsi Tugas -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="input-deskripsi" class="text-sm font-bold text-gray-800">
                                Deskripsi Tugas <span class="text-red-500">*</span>
                            </label>
                            <span class="text-xs text-gray-400">Jelaskan perlengkapan &amp; kondisi</span>
                        </div>
                        <div class="bg-[#f8f9fa] border border-gray-200/90 rounded-xl p-4 flex items-start gap-3 focus-within:bg-white focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition">
                            <span class="material-symbols-outlined text-gray-400 text-[20px] mt-0.5">segment</span>
                            <textarea id="input-deskripsi" name="deskripsi" rows="4" required
                                placeholder="Jelaskan rincian pekerjaan, tanggung jawab, dan kondisi kerja serabutan secara jelas..."
                                class="w-full bg-transparent text-sm text-gray-800 focus:outline-none placeholder:text-gray-400 resize-none font-medium leading-relaxed">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>

                    <!-- 3. Lokasi Kerja & Peta Interaktif (Map, Click, Long & Lat) -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="input-lokasi" class="text-sm font-bold text-gray-800">
                                Lokasi Kerja &amp; Titik Peta <span class="text-red-500">*</span>
                            </label>
                            <button type="button" id="btn-current-location" class="text-xs font-semibold text-purple-700 hover:text-purple-900 flex items-center gap-1 transition">
                                <span class="material-symbols-outlined text-[16px]">my_location</span>
                                Gunakan Lokasi Saya
                            </button>
                        </div>
                        
                        <!-- Input Nama / Alamat Lokasi -->
                        <div class="bg-[#f8f9fa] border border-gray-200/90 rounded-xl px-4 py-3 flex items-center gap-3 focus-within:bg-white focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition mb-3">
                            <span class="material-symbols-outlined text-gray-400 text-[20px]">location_on</span>
                            <input type="text" id="input-lokasi" name="lokasi" required
                                value="{{ old('lokasi') }}"
                                placeholder="contoh: Pergudangan Margomulyo Blok B-12"
                                class="w-full bg-transparent text-sm text-gray-800 focus:outline-none placeholder:text-gray-400 font-medium">
                        </div>

                        <!-- Peta Interaktif Leaflet -->
                        <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm relative">
                            <div id="map" class="w-full h-64 z-10"></div>
                            <div class="absolute bottom-2 left-2 z-20 bg-white/95 backdrop-blur px-3 py-1.5 rounded-lg text-[11px] text-gray-600 font-medium border border-gray-200 shadow-sm pointer-events-none flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-purple-600">touch_app</span>
                                <span>Klik pada peta atau geser pin untuk menentukan titik koordinat</span>
                            </div>
                        </div>

                        <!-- Grid Latitude & Longitude Inputs -->
                        <div class="grid grid-cols-2 gap-3 mt-3">
                            <div>
                                <label for="input-latitude" class="block text-[11px] font-bold text-gray-600 mb-1">
                                    Latitude (Garis Lintang)
                                </label>
                                <div class="bg-[#f8f9fa] border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2">
                                    <span class="text-[11px] font-mono font-bold text-gray-400">LAT:</span>
                                    <input type="text" id="input-latitude" name="latitude" required
                                        value="{{ old('latitude', '-6.200000') }}"
                                        class="w-full bg-transparent text-xs font-mono font-semibold text-gray-800 focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label for="input-longitude" class="block text-[11px] font-bold text-gray-600 mb-1">
                                    Longitude (Garis Bujur)
                                </label>
                                <div class="bg-[#f8f9fa] border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2">
                                    <span class="text-[11px] font-mono font-bold text-gray-400">LNG:</span>
                                    <input type="text" id="input-longitude" name="longitude" required
                                        value="{{ old('longitude', '106.816666') }}"
                                        class="w-full bg-transparent text-xs font-mono font-semibold text-gray-800 focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 & 5. Grid Upah & Durasi Kerja -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="input-upah" class="block text-sm font-bold text-gray-800 mb-2">
                                Upah / Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-[#f8f9fa] border border-gray-200/90 rounded-xl px-4 py-3 flex items-center gap-3 focus-within:bg-white focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition">
                                <span class="material-symbols-outlined text-gray-400 text-[20px]">payments</span>
                                <input type="text" id="input-upah" name="upah" required
                                    value="{{ old('upah') }}"
                                    placeholder="contoh: Rp 150.000 / hari (Langsung"
                                    class="w-full bg-transparent text-sm text-gray-800 focus:outline-none placeholder:text-gray-400 font-medium">
                            </div>
                        </div>
                        <div>
                            <label for="input-durasi" class="block text-sm font-bold text-gray-800 mb-2">
                                Durasi Kerja (Shift) <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-[#f8f9fa] border border-gray-200/90 rounded-xl px-4 py-3 flex items-center gap-3 focus-within:bg-white focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition">
                                <span class="material-symbols-outlined text-gray-400 text-[20px]">schedule</span>
                                <input type="text" id="input-durasi" name="durasi" required
                                    value="{{ old('durasi') }}"
                                    placeholder="contoh: 1 Hari (Pukul 08.00 - 16.00 WIB)"
                                    class="w-full bg-transparent text-sm text-gray-800 focus:outline-none placeholder:text-gray-400 font-medium">
                            </div>
                        </div>
                    </div>

                    <!-- Batas Waktu Pembukaan Lowongan (Deadline) -->
                    <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200/80 space-y-3">
                        <div class="flex items-center justify-between">
                            <label for="input-deadline" class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-amber-600 text-[18px]">timer</span>
                                <span>Batas Waktu Pembukaan Lowongan (Kadaluarsa)</span>
                            </label>
                            <span class="text-[11px] text-amber-700 font-semibold bg-amber-100/70 px-2.5 py-0.5 rounded-full">
                                Otomatis Ditutup Jika Lewat Batas
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">
                            Tentukan batas akhir pelamar dapat mengirim lamaran. Jika waktu habis, lowongan otomatis ditutup dan tombol lamar akan dinonaktifkan.
                        </p>
                        
                        <!-- Pilihan Cepat Preset Waktu -->
                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            <span class="text-xs font-semibold text-gray-600 mr-1">Preset cepat:</span>
                            <button type="button" onclick="setDeadlinePreset(6)"
                                class="px-2.5 py-1 rounded-lg bg-white border border-amber-200 text-xs font-semibold text-gray-700 hover:bg-amber-100 transition shadow-2xs">
                                6 Jam
                            </button>
                            <button type="button" onclick="setDeadlinePreset(12)"
                                class="px-2.5 py-1 rounded-lg bg-white border border-amber-200 text-xs font-semibold text-gray-700 hover:bg-amber-100 transition shadow-2xs">
                                12 Jam
                            </button>
                            <button type="button" onclick="setDeadlinePreset(24)"
                                class="px-2.5 py-1 rounded-lg bg-white border border-amber-200 text-xs font-semibold text-gray-700 hover:bg-amber-100 transition shadow-2xs">
                                1 Hari (24 Jam)
                            </button>
                            <button type="button" onclick="setDeadlinePreset(72)"
                                class="px-2.5 py-1 rounded-lg bg-white border border-amber-200 text-xs font-semibold text-gray-700 hover:bg-amber-100 transition shadow-2xs">
                                3 Hari
                            </button>
                            <button type="button" onclick="setDeadlinePreset(168)"
                                class="px-2.5 py-1 rounded-lg bg-white border border-amber-200 text-xs font-semibold text-gray-700 hover:bg-amber-100 transition shadow-2xs">
                                7 Hari
                            </button>
                        </div>

                        <!-- Input Datetime -->
                        <div class="bg-white border border-amber-300 rounded-xl px-4 py-2.5 flex items-center gap-3 focus-within:ring-2 focus-within:ring-amber-200 transition">
                            <span class="material-symbols-outlined text-amber-600 text-[20px]">event</span>
                            <input type="datetime-local" id="input-deadline" name="deadline_pendaftaran"
                                value="{{ old('deadline_pendaftaran') }}"
                                class="w-full bg-transparent text-sm text-gray-800 focus:outline-none font-medium">
                        </div>
                    </div>

                    <!-- 6. Skill yang Dibutuhkan -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-bold text-gray-800">Skill yang Dibutuhkan</label>
                            <span class="text-xs text-gray-400">Tekan Enter untuk menambah</span>
                        </div>
                        <div id="skills-container" class="bg-[#f8f9fa] border border-gray-200/90 rounded-xl p-3 min-h-[85px] flex flex-wrap items-center gap-2 focus-within:bg-white focus-within:border-purple-600 focus-within:ring-2 focus-within:ring-purple-100 transition">
                            <!-- Tag Chips Default -->
                            <span class="tag-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#ede9fe] text-[#6b21a8] text-xs font-semibold">
                                <span class="material-symbols-outlined text-[14px]">local_offer</span>
                                <span>Fisik Kuat</span>
                                <button type="button" onclick="removeTag(this, 'Fisik Kuat')" class="text-purple-400 hover:text-purple-800 ml-1 font-bold">&times;</button>
                            </span>
                            <span class="tag-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#ede9fe] text-[#6b21a8] text-xs font-semibold">
                                <span>Tepat Waktu</span>
                                <button type="button" onclick="removeTag(this, 'Tepat Waktu')" class="text-purple-400 hover:text-purple-800 ml-1 font-bold">&times;</button>
                            </span>
                            <span class="tag-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#ede9fe] text-[#6b21a8] text-xs font-semibold">
                                <span>Jujur &amp; Disiplin</span>
                                <button type="button" onclick="removeTag(this, 'Jujur & Disiplin')" class="text-purple-400 hover:text-purple-800 ml-1 font-bold">&times;</button>
                            </span>
                            <!-- Input Tambah Tag -->
                            <input type="text" id="skill-input" placeholder="+ Tambah skill lalu tekan Enter"
                                class="bg-transparent text-xs text-gray-700 focus:outline-none placeholder:text-gray-400 py-1 min-w-[200px] flex-1">
                        </div>
                        <input type="hidden" name="skills" id="skills-hidden" value="Fisik Kuat, Tepat Waktu, Jujur & Disiplin">
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-gray-100">
                        <button type="submit" name="action" value="draft"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">description</span>
                            Simpan sebagai Draf
                        </button>
                        <button type="submit" name="action" value="publish"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#7c3aed] hover:bg-[#6d28d9] text-white text-sm font-bold shadow-md shadow-purple-600/25 transition">
                            <span class="material-symbols-outlined text-[18px]">near_me</span>
                            Tayangkan Lowongan
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: PRATINJAU & TIPS (5 Kolom) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- 1. Card Pratinjau Publik -->
            <div>
                <div class="flex items-center justify-between mb-3 px-1">
                    <span class="text-[11px] font-bold tracking-wider text-gray-500 uppercase">PRATINJAU KARTU PUBLIK</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 text-[11px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif Cepat
                    </span>
                </div>

                <div class="bg-white border border-gray-200/90 rounded-2xl p-6 shadow-sm">
                    <!-- Top Info -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-full bg-[#5b21b6] text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name ?? 'MB', 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 leading-tight">
                                    {{ auth()->user()->name ?? 'PT Maju Bersama' }}
                                </h4>
                                <p class="text-[11px] text-gray-400 mt-0.5">Baru saja</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-100 text-[11px] font-bold shrink-0">
                            Harian
                        </span>
                    </div>

                    <!-- Job Title Preview -->
                    <h3 id="preview-judul" class="font-bold text-gray-900 text-base mt-4 leading-snug">
                        Tukang Angkut Barang Pindahan Kantor
                    </h3>

                    <!-- Job Snippet Preview -->
                    <p id="preview-deskripsi" class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                        Pekerjaan membutuhkan kesiapan fisik untuk membantu pemindahan barang inventaris...
                    </p>

                    <!-- Meta Details -->
                    <div class="mt-4 space-y-2.5 text-xs text-gray-600 border-t border-gray-100 pt-3.5">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#7c3aed] text-[17px] shrink-0">location_on</span>
                            <span id="preview-lokasi" class="truncate font-medium text-gray-700">Pergudangan Margomulyo Blok B-12,...</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-[17px] shrink-0">payments</span>
                            <span id="preview-upah" class="font-bold text-emerald-700">Rp 150.000 / hari</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400 text-[17px] shrink-0">schedule</span>
                            <span id="preview-durasi" class="truncate font-medium text-gray-600">1 Hari (08.00 - 16.00 WIB)</span>
                        </div>
                        <div class="flex items-center gap-2 text-[11px] text-purple-700 font-mono pl-6">
                            <span class="material-symbols-outlined text-[14px]">pin_drop</span>
                            <span id="preview-koordinat">[-6.200000, 106.816666]</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Card Tips Menarik Pekerja Cepat -->
            <div class="bg-[#fcf8ff] border border-purple-100/90 rounded-2xl p-5 space-y-4">
                <div class="flex items-center gap-2 text-[#6b21a8] font-bold text-sm">
                    <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                    <span>Tips Menarik Pekerja Cepat</span>
                </div>

                <ul class="space-y-3 text-xs text-gray-700 leading-relaxed">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-gray-700 text-[16px] mt-0.5 shrink-0">check_circle</span>
                        <span><strong class="font-semibold text-gray-900">Upah Transparan:</strong> Sebutkan nominal bersih dan kejelasan waktu pencairan (misal: harian tunai).</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-gray-700 text-[16px] mt-0.5 shrink-0">check_circle</span>
                        <span><strong class="font-semibold text-gray-900">Lokasi Spesifik &amp; Peta:</strong> Tentukan pin lokasi dengan tepat agar pekerja bisa melihat jarak tempuh.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-gray-700 text-[16px] mt-0.5 shrink-0">check_circle</span>
                        <span><strong class="font-semibold text-gray-900">Skill Tepat:</strong> Pilih 3-4 kualifikasi utama agar tidak membatasi pelamar lokal yang berminat.</span>
                    </li>
                </ul>

                <!-- Support Box -->
                <div class="bg-white rounded-xl p-3 border border-purple-100 flex items-center gap-3 shadow-[0_1px_4px_rgba(0,0,0,0.02)]">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[18px]">support_agent</span>
                    </div>
                    <div class="text-xs">
                        <p class="text-gray-500 font-medium">Butuh bantuan posting?</p>
                        <a href="#" class="font-bold text-purple-700 hover:underline">Hubungi Admin Ketenagakerjaan</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Live update pratinjau kartu publik ---
        const inputJudul = document.getElementById('input-judul');
        const inputDeskripsi = document.getElementById('input-deskripsi');
        const inputLokasi = document.getElementById('input-lokasi');
        const inputUpah = document.getElementById('input-upah');
        const inputDurasi = document.getElementById('input-durasi');

        const previewJudul = document.getElementById('preview-judul');
        const previewDeskripsi = document.getElementById('preview-deskripsi');
        const previewLokasi = document.getElementById('preview-lokasi');
        const previewUpah = document.getElementById('preview-upah');
        const previewDurasi = document.getElementById('preview-durasi');
        const previewKoordinat = document.getElementById('preview-koordinat');

        inputJudul.addEventListener('input', function() {
            previewJudul.textContent = this.value.trim() || 'Tukang Angkut Barang Pindahan Kantor';
        });

        inputDeskripsi.addEventListener('input', function() {
            previewDeskripsi.textContent = this.value.trim() || 'Pekerjaan membutuhkan kesiapan fisik untuk membantu pemindahan barang inventaris...';
        });

        inputLokasi.addEventListener('input', function() {
            previewLokasi.textContent = this.value.trim() || 'Pergudangan Margomulyo Blok B-12,...';
        });

        inputUpah.addEventListener('input', function() {
            previewUpah.textContent = this.value.trim() || 'Rp 150.000 / hari';
        });

        inputDurasi.addEventListener('input', function() {
            previewDurasi.textContent = this.value.trim() || '1 Hari (08.00 - 16.00 WIB)';
        });

        // --- 2. Leaflet Map Interactive (Click & Drag for Lat/Long) ---
        const inputLat = document.getElementById('input-latitude');
        const inputLng = document.getElementById('input-longitude');

        let initialLat = parseFloat(inputLat.value) || -6.200000;
        let initialLng = parseFloat(inputLng.value) || 106.816666;

        const map = L.map('map').setView([initialLat, initialLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        function updateCoordinates(lat, lng) {
            inputLat.value = lat.toFixed(6);
            inputLng.value = lng.toFixed(6);
            if (previewKoordinat) {
                previewKoordinat.textContent = `[${lat.toFixed(6)}, ${lng.toFixed(6)}]`;
            }
        }

        // Event saat klik pada peta
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
        });

        // Event saat marker digeser
        marker.on('dragend', function(e) {
            const pos = marker.getLatLng();
            updateCoordinates(pos.lat, pos.lng);
        });

        // Event perubahan manual input Lat/Long
        inputLat.addEventListener('change', function() {
            const lat = parseFloat(this.value);
            const lng = parseFloat(inputLng.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
                updateCoordinates(lat, lng);
            }
        });

        inputLng.addEventListener('change', function() {
            const lat = parseFloat(inputLat.value);
            const lng = parseFloat(this.value);
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.panTo([lat, lng]);
                updateCoordinates(lat, lng);
            }
        });

        // Tombol Gunakan Lokasi GPS Saya
        const btnGps = document.getElementById('btn-current-location');
        if (btnGps) {
            btnGps.addEventListener('click', function() {
                if (navigator.geolocation) {
                    btnGps.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin">sync</span> Mencari...';
                    navigator.geolocation.getCurrentPosition(function(pos) {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 16);
                        updateCoordinates(lat, lng);
                        btnGps.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span> Lokasi Ditemukan';
                        setTimeout(() => {
                            btnGps.innerHTML = '<span class="material-symbols-outlined text-[16px]">my_location</span> Gunakan Lokasi Saya';
                        }, 3000);
                    }, function(err) {
                        alert('Gagal mengambil lokasi GPS Anda: ' + err.message);
                        btnGps.innerHTML = '<span class="material-symbols-outlined text-[16px]">my_location</span> Gunakan Lokasi Saya';
                    });
                } else {
                    alert('Browser Anda tidak mendukung geolokasi.');
                }
            });
        }

        // --- 3. Pengelolaan tags skill ---
        const skillInput = document.getElementById('skill-input');
        const skillsContainer = document.getElementById('skills-container');
        const skillsHidden = document.getElementById('skills-hidden');
        let skills = ['Fisik Kuat', 'Tepat Waktu', 'Jujur & Disiplin'];

        function updateHiddenInput() {
            skillsHidden.value = skills.join(', ');
        }

        window.removeTag = function(button, tagText) {
            skills = skills.filter(s => s !== tagText);
            button.closest('.tag-chip').remove();
            updateHiddenInput();
        };

        skillInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const newTag = this.value.trim();
                if (newTag && !skills.includes(newTag)) {
                    skills.push(newTag);
                    updateHiddenInput();

                    const span = document.createElement('span');
                    span.className = 'tag-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#ede9fe] text-[#6b21a8] text-xs font-semibold';
                    span.innerHTML = `<span>${newTag}</span><button type="button" onclick="removeTag(this, '${newTag}')" class="text-purple-400 hover:text-purple-800 ml-1 font-bold">&times;</button>`;
                    skillsContainer.insertBefore(span, skillInput);
                    this.value = '';
                }
            }
        });
        window.setDeadlinePreset = function(hours) {
            const now = new Date();
            now.setHours(now.getHours() + hours);
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const inputDeadline = document.getElementById('input-deadline');
            if (inputDeadline) {
                inputDeadline.value = `${year}-${month}-${day}T${h}:${m}`;
            }
        };

        // Default: atur preset 1 hari (24 jam) jika belum ada nilai
        const inputDeadline = document.getElementById('input-deadline');
        if (inputDeadline && !inputDeadline.value) {
            setDeadlinePreset(24);
        }
    });
</script>
@endpush
