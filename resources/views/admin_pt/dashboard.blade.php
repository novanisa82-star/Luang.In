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
                    Pantau lowongan dan kelola pelamar perusahaan Anda, <span class="font-semibold text-on-surface">{{ auth()->user()->name ?? 'Mitra Perusahaan' }}</span>
                </p>
            </div>
            <div>
                <button class="bg-primary hover:bg-primary-container text-on-primary px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add</span> Buat Lowongan Baru
                </button>
            </div>
        </div>

        <!-- 2. Grid 3 Card Metrik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-surface-container-lowest rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-sm text-secondary">Lowongan Aktif</span>
                        <h3 class="text-3xl font-bold text-on-surface mt-2">8</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-secondary-fixed flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[22px]">work</span>
                    </div>
                </div>
                <div class="mt-4 text-xs font-medium text-tertiary flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span> 2 lowongan baru minggu ini
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-sm text-secondary">Pelamar Masuk</span>
                        <h3 class="text-3xl font-bold text-on-surface mt-2">24</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-700">
                        <span class="material-symbols-outlined text-[22px]">group</span>
                    </div>
                </div>
                <div class="mt-4 text-xs font-medium text-amber-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">schedule</span> Perlu ditinjau segera
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-sm text-secondary">Kandidat Diterima</span>
                        <h3 class="text-3xl font-bold text-on-surface mt-2">15</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-700">
                        <span class="material-symbols-outlined text-[22px]">check_circle</span>
                    </div>
                </div>
                <div class="mt-4 text-xs font-medium text-emerald-700 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">verified</span> Tingkat konversi 62.5%
                </div>
            </div>
        </div>

        <!-- 3. Chart.js Section -->
        <div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-on-surface">Statistik Pelamar Masuk Harian</h2>
                    <p class="text-xs text-secondary">Grafik aktivitas pelamar pada lowongan perusahaan Anda (7 hari terakhir)</p>
                </div>
                <span class="px-2.5 py-1 bg-surface-container rounded-lg text-xs font-medium text-secondary flex items-center gap-1">
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
                <h2 class="text-lg font-bold text-on-surface">Status Lowongan Perusahaan</h2>
                <span class="text-xs text-secondary font-medium">Menampilkan lowongan aktif</span>
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
                        @forelse($pendingPekerjaan ?? [] as $job)
                        <tr>
                            <td class="py-4 font-semibold text-on-surface">{{ $job->judul }}</td>
                            <td class="py-4 text-secondary">Rp {{ number_format($job->upah, 0, ',', '.') }} / {{ $job->durasi }}</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 text-xs rounded-full bg-amber-100 text-amber-800 font-medium">Menunggu Verifikasi</span>
                            </td>
                            <td class="py-4 space-x-2">
                                <a href="#" class="text-primary hover:underline font-semibold text-xs">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-secondary">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-[32px] text-secondary/60">work_off</span>
                                    <span>Belum ada lowongan aktif yang ditambahkan.</span>
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
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1b1b1c',
                        titleFont: { size: 12 },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#5f5d6b', font: { family: 'Plus Jakarta Sans', size: 12 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0eded' },
                        ticks: { color: '#5f5d6b', font: { family: 'Plus Jakarta Sans', size: 12 }, stepSize: 5 }
                    }
                }
            }
        });
    });
</script>
@endpush