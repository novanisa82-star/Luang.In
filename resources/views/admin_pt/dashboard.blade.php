@extends('admin_pt.layouts.app')

@section('header-title', 'Beranda Perusahaan')

@section('content')
    <div class="w-full px-8 py-8">
        <div class="flex flex-col w-full gap-8">

            <!-- 1. Header Konten -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-on-surface tracking-tight">Beranda PT</h1>
                    <p class="text-sm text-secondary mt-1">
                        Pantau lowongan dan kelola pelamar perusahaan Anda, <span
                            class="font-semibold text-on-surface">{{ auth()->user()->name ?? 'Mitra Perusahaan' }}</span>
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin_pt.lowongan.create') }}"
                        class="bg-primary hover:bg-primary-container text-on-primary px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">add</span> Buat Lowongan Baru
                    </a>
                </div>
            </div>

            <!-- Warning Pengaduan / Peringatan dari Superadmin (Jika Ada) -->
            @if(isset($activeWarnings) && $activeWarnings->isNotEmpty())
                <div class="bg-red-50/90 border-2 border-red-300 rounded-2xl p-6 shadow-sm space-y-4 animate-fade-in">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center shrink-0 shadow-sm animate-pulse">
                            <span class="material-symbols-outlined text-[24px]">warning</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <h3 class="text-base font-extrabold text-red-950">
                                    PERINGATAN DARI SUPERADMIN: Terdapat {{ $activeWarnings->count() }} Pengaduan Aktif
                                </h3>
                                <span class="px-3 py-1 rounded-full bg-red-200 text-red-900 text-xs font-black uppercase w-fit">
                                    Perlu Perhatian Segera
                                </span>
                            </div>
                            <p class="text-xs text-red-800 mt-1 leading-relaxed">
                                Terdapat laporan pengaduan dari pekerja/pelamar terkait operasional atau lowongan perusahaan Anda. Harap segera tindak lanjuti dan patuhi instruksi Superadmin di bawah ini untuk menghindari penonaktifan (suspend) akun PT.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        @foreach($activeWarnings as $warning)
                            <div class="bg-white rounded-xl p-4 border border-red-200/80 shadow-sm space-y-2">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded text-[11px] font-extrabold bg-red-100 text-red-800">
                                            #LAP-{{ $warning->id }}
                                        </span>
                                        <span class="text-xs font-bold text-gray-900">{{ $warning->judul }}</span>
                                    </div>
                                    <span class="text-[11px] text-gray-400 font-semibold">
                                        {{ $warning->created_at ? $warning->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                    </span>
                                </div>

                                <p class="text-xs text-gray-600 leading-relaxed">
                                    <span class="font-semibold text-gray-800">Detail Aduan:</span> {{ $warning->deskripsi }}
                                </p>

                                @if($warning->pekerjaan)
                                    <p class="text-xs text-purple-700 font-semibold">
                                        Lowongan Terkait: {{ $warning->pekerjaan->judul }}
                                    </p>
                                @endif

                                @if($warning->tindakan_superadmin)
                                    <div class="p-3 bg-red-50/70 border border-red-200 rounded-xl text-xs text-red-950 flex items-start gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-red-600 shrink-0 mt-0.5">gavel</span>
                                        <div>
                                            <span class="font-extrabold block text-red-900 uppercase text-[10px]">Instruksi / Catatan Superadmin:</span>
                                            <span class="font-semibold">{{ $warning->tindakan_superadmin }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 2. Grid 3 Card Metrik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div
                    class="bg-surface-container-lowest rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-sm text-secondary">Lowongan Aktif</span>
                            <h3 class="text-3xl font-bold text-on-surface mt-2">{{ $lowonganAktifCount ?? 0 }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-secondary-fixed flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[22px]">work</span>
                        </div>
                    </div>
                    <div class="mt-4 text-xs font-medium text-tertiary flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">trending_up</span> Lowongan aktif perusahaan
                    </div>
                </div>

                <div
                    class="bg-surface-container-lowest rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-sm text-secondary">Pelamar Masuk</span>
                            <h3 class="text-3xl font-bold text-on-surface mt-2">{{ $pelamarMasukCount ?? 0 }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700">
                            <span class="material-symbols-outlined text-[22px]">group</span>
                        </div>
                    </div>
                    <div class="mt-4 text-xs font-medium text-amber-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">schedule</span> Total pelamar masuk
                    </div>
                </div>

                <div
                    class="bg-surface-container-lowest rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-sm text-secondary">Kandidat Diterima</span>
                            <h3 class="text-3xl font-bold text-on-surface mt-2">{{ $kandidatDiterimaCount ?? 0 }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                            <span class="material-symbols-outlined text-[22px]">check_circle</span>
                        </div>
                    </div>
                    <div class="mt-4 text-xs font-medium text-emerald-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">verified</span> Kandidat siap dipekerjakan
                    </div>
                </div>
            </div>

            <!-- 3. Chart.js Section -->
            <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-on-surface">Statistik Pelamar Masuk Harian</h2>
                        <p class="text-xs text-secondary">Grafik aktivitas pelamar pada lowongan perusahaan Anda (7 hari
                            terakhir)</p>
                    </div>
                    <span
                        class="px-2.5 py-1 bg-surface-container rounded-lg text-xs font-medium text-secondary flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Realtime
                    </span>
                </div>
                <div class="w-full h-64 relative">
                    <canvas id="trenTenagaKerjaChart"></canvas>
                </div>
            </div>

            <!-- 4. Tabel Daftar Lowongan -->
            <div class="bg-surface-container-lowest rounded-xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-on-surface">Status Lowongan Terbaru Perusahaan</h2>
                    <a href="{{ route('admin_pt.lowongan.index') }}" class="text-xs text-primary font-semibold hover:underline">Lihat Semua Lowongan</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-surface-container">
                        <thead>
                            <tr class="text-left text-xs font-semibold text-secondary uppercase">
                                <th class="pb-3">Judul Loker</th>
                                <th class="pb-3">Upah / Durasi</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container text-sm">
                            @forelse($recentPekerjaan ?? [] as $job)
                                <tr>
                                    <td class="py-4 font-semibold text-on-surface">{{ $job->judul }}</td>
                                    <td class="py-4 text-secondary">Rp {{ number_format((float)$job->upah, 0, ',', '.') }} /
                                        {{ $job->durasi }}</td>
                                    <td class="py-4">
                                        @if ($job->status_moderasi === 'menunggu')
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-amber-100 text-amber-800 font-medium">Menunggu Verifikasi</span>
                                        @elseif ($job->status_moderasi === 'ditolak')
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-red-100 text-red-800 font-medium">Ditolak</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-100 text-emerald-800 font-medium">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-4 space-x-2">
                                        <a href="{{ route('admin_pt.lowongan.show', $job->id) }}"
                                            class="text-primary hover:underline font-semibold text-xs">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-secondary">
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <span
                                                class="material-symbols-outlined text-[32px] text-secondary/60">work_off</span>
                                            <span>Belum ada lowongan yang ditambahkan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <!-- CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('trenTenagaKerjaChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Jumlah Pelamar',
                        data: [4, 7, 5, 9, 12, 18, 6],
                        backgroundColor: [
                            'rgba(240, 237, 240, 0.8)',
                            'rgba(240, 237, 240, 0.8)',
                            'rgba(240, 237, 240, 0.8)',
                            'rgba(240, 237, 240, 0.8)',
                            'rgba(240, 237, 240, 0.8)',
                            '#7c3aed',
                            'rgba(240, 237, 240, 0.8)'
                        ],
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1b1b1c',
                            titleFont: {
                                size: 12
                            },
                            bodyFont: {
                                size: 12
                            },
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#5f5d6b',
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f0eded'
                            },
                            ticks: {
                                color: '#5f5d6b',
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    size: 12
                                },
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
