@extends('admin_pt.layouts.app')

@section('header-title', 'Buat Lowongan Baru')

@section('content')
    <div class="w-full px-8 py-8">
        <div class="max-w-3xl flex flex-col gap-6">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-on-surface tracking-tight">Buat Lowongan Baru</h1>
                    <p class="text-sm text-secondary mt-1">Isi formulir berikut untuk menerbitkan lowongan pekerjaan baru.
                    </p>
                </div>
                <a href="{{ route('admin_pt.lowongan.index') }}"
                    class="text-sm font-medium text-secondary hover:text-on-surface flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-surface-container-lowest rounded-xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] p-6">
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                        <p class="font-semibold mb-1">Terjadi kesalahan input:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin_pt.lowongan.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="judul" class="block text-sm font-semibold text-on-surface mb-1.5">Judul
                            Pekerjaan</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                            placeholder="Contoh: Barista Paruh Waktu"
                            class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-on-surface text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="upah" class="block text-sm font-semibold text-on-surface mb-1.5">Upah / Gaji
                                (Rp)</label>
                            <input type="number" id="upah" name="upah" value="{{ old('upah') }}" required
                                placeholder="Contoh: 150000"
                                class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-on-surface text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition">
                        </div>
                        <div>
                            <label for="durasi" class="block text-sm font-semibold text-on-surface mb-1.5">Durasi
                                Pekerjaan</label>
                            <input type="text" id="durasi" name="durasi" value="{{ old('durasi') }}" required
                                placeholder="Contoh: 1 Hari, 2 Minggu, 1 Bulan"
                                class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-on-surface text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition">
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-on-surface mb-1.5">Deskripsi
                            Pekerjaan</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            placeholder="Jelaskan kriteria, tanggung jawab, dan persyaratan lowongan..."
                            class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-on-surface text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-on-surface mb-1.5">Latitude Lokasi
                                (Opsional)</label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude', '-6.200000') }}"
                                placeholder="-6.200000"
                                class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-on-surface text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition">
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-on-surface mb-1.5">Longitude
                                Lokasi (Opsional)</label>
                            <input type="text" id="longitude" name="longitude"
                                value="{{ old('longitude', '106.816666') }}" placeholder="106.816666"
                                class="w-full px-4 py-2.5 rounded-xl border border-surface-container bg-surface text-on-surface text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition">
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('admin_pt.lowongan.index') }}"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-secondary hover:bg-surface-container transition">Batal</a>
                        <button type="submit"
                            class="bg-primary hover:bg-primary-container text-on-primary px-6 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span> Simpan Lowongan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
