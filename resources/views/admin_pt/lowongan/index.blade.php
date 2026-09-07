@extends('admin_pt.layouts.app')

@section('header-title', 'Kelola Lowongan')

@section('content')
<div class="w-full px-8 py-8">
    <div class="flex flex-col w-full gap-6">
        
        <!-- Header & Tombol Tambah -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-on-surface tracking-tight">Daftar Lowongan Perusahaan</h1>
                <p class="text-sm text-secondary mt-1">Kelola, ubah, atau buat lowongan pekerjaan baru untuk pelamar.</p>
            </div>
            <div>
                <a href="{{ route('admin.pt.lowongan.create') }}" class="bg-primary hover:bg-primary-container text-on-primary px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add</span> Buat Lowongan Baru
                </a>
            </div>
        </div>

        <!-- Tabel Lowongan -->
        <div class="bg-surface-container-lowest rounded-xl shadow-[0_2px_8px_rgba(0,0,0,0.04)] p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-surface-container">
                    <thead>
                        <tr class="text-left text-xs font-semibold text-secondary uppercase">
                            <th class="pb-3">Judul Lowongan</th>
                            <th class="pb-3">Upah / Gaji</th>
                            <th class="pb-3">Durasi</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container text-sm">
                        @forelse($lowongans ?? [] as $job)
                        <tr>
                            <td class="py-4 font-semibold text-on-surface">{{ $job->judul }}</td>
                            <td class="py-4 text-secondary">Rp {{ number_format($job->upah, 0, ',', '.') }}</td>
                            <td class="py-4 text-secondary">{{ $job->durasi }}</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 text-xs rounded-full bg-emerald-100 text-emerald-800 font-medium">
                                    {{ $job->status ?? 'Aktif' }}
                                </span>
                            </td>
                            <td class="py-4 text-right space-x-2">
                                <a href="#" class="text-primary hover:underline font-semibold text-xs">Edit</a>
                                <span class="text-secondary">|</span>
                                <a href="#" class="text-red-600 hover:underline font-semibold text-xs">Hapus</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-secondary">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[40px] text-secondary/50">work_off</span>
                                    <p class="font-medium text-on-surface">Belum ada lowongan yang dibuat</p>
                                    <p class="text-xs text-secondary">Mulai buat lowongan pertama Anda dengan menekan tombol di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Jika ada) -->
            @if(isset($lowongans) && method_exists($lowongans, 'links'))
            <div class="mt-4">
                {{ $lowongans->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection