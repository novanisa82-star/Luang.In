@extends('admin_pt.layouts.app')

@section('header-title', 'Kelola Lowongan')

@section('content')
    <div class="w-full px-8 py-8">
        <div class="flex flex-col w-full gap-6">

            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="material-symbols-outlined text-primary text-[22px]">
                            work
                        </span>
                        <h1 class="text-2xl font-bold tracking-tight text-on-surface">
                            Daftar Lowongan Perusahaan
                        </h1>
                    </div>

                    <p class="text-sm text-secondary">
                        Kelola, ubah, atau buat lowongan pekerjaan baru untuk pelamar.
                    </p>
                </div>

                <!-- Tombol Tambah -->
                <a href="{{ route('admin_pt.lowongan.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                           rounded-xl bg-primary text-on-primary text-sm font-semibold
                           shadow-sm transition-all duration-200
                           hover:bg-primary-container hover:-translate-y-0.5 hover:shadow-md">

                    <span class="material-symbols-outlined text-[19px]">
                        add
                    </span>

                    Buat Lowongan Baru
                </a>
            </div>

            @if (session('success'))
                <div
                    class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2.5 shadow-sm">
                    <span class="material-symbols-outlined text-[20px] text-emerald-600 shrink-0">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif


            <!-- Tabel Card -->
            <div
                class="overflow-hidden bg-surface-container-lowest
                       rounded-2xl border border-surface-container
                       shadow-[0_2px_10px_rgba(0,0,0,0.04)]">

                <!-- Table Header -->
                <div
                    class="flex flex-col gap-2 px-6 py-5
                           border-b border-surface-container
                           sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h2 class="text-base font-bold text-on-surface">
                            Semua Lowongan
                        </h2>

                        <p class="mt-0.5 text-xs text-secondary">
                            Daftar posisi pekerjaan yang tersedia.
                        </p>
                    </div>

                    @if (isset($lowongans))
                        <div
                            class="inline-flex items-center gap-1.5 self-start
                                   rounded-full bg-surface-container px-3 py-1.5
                                   text-xs font-medium text-secondary sm:self-auto">

                            <span class="material-symbols-outlined text-[15px]">
                                work_history
                            </span>

                            {{ $lowongans->count() }} Lowongan
                        </div>
                    @endif
                </div>


                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">

                        <!-- Table Head -->
                        <thead class="bg-surface-container-low">
                            <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-secondary">

                                <th class="px-6 py-4">
                                    Judul Lowongan
                                </th>

                                <th class="px-6 py-4">
                                    Upah / Gaji
                                </th>

                                <th class="px-6 py-4">
                                    Durasi
                                </th>

                                <th class="px-6 py-4">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right">
                                    Aksi
                                </th>

                            </tr>
                        </thead>


                        <!-- Table Body -->
                        <tbody class="divide-y divide-surface-container">

                            @forelse($lowongans ?? [] as $job)
                                <tr
                                    class="group text-sm transition-colors duration-150
                                           hover:bg-surface-container-low/60">

                                    <!-- Judul -->
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center
                                                       rounded-xl bg-primary/10 text-primary
                                                       transition-transform duration-200
                                                       group-hover:scale-105">

                                                <span class="material-symbols-outlined text-[20px]">
                                                    work
                                                </span>

                                            </div>

                                            <div>
                                                <p class="font-semibold text-on-surface">
                                                    {{ $job->judul }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-secondary">
                                                    Lowongan pekerjaan
                                                </p>
                                            </div>

                                        </div>

                                    </td>


                                    <!-- Gaji -->
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-on-surface">
                                            Rp {{ number_format((float) $job->upah, 0, ',', '.') }}
                                        </span>
                                    </td>


                                    <!-- Durasi -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-secondary">

                                            <span class="material-symbols-outlined text-[17px]">
                                                schedule
                                            </span>

                                            {{ $job->durasi }}

                                        </div>
                                    </td>


                                    <!-- Status -->
                                    <td class="px-6 py-4">

                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   rounded-full bg-emerald-50
                                                   px-3 py-1.5
                                                   text-xs font-semibold
                                                   text-emerald-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            {{ ucfirst($job->status_loker ?? ($job->status ?? 'Aktif')) }}

                                        </span>

                                    </td>


                                    <!-- Aksi -->
                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-end gap-2">

                                            <!-- Lihat / Detail -->
                                            <a href="{{ route('admin_pt.lowongan.show', $job->id) }}"
                                                title="Lihat Detail Lowongan"
                                                class="flex h-9 w-9 items-center justify-center
                                                       rounded-lg border border-gray-200
                                                       bg-gray-50 text-gray-600
                                                       transition-all duration-200
                                                       hover:bg-purple-700 hover:text-white hover:border-purple-700
                                                       hover:shadow-sm">
                                                <span class="material-symbols-outlined text-[18px]">
                                                    visibility
                                                </span>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('admin_pt.lowongan.edit', $job->id) }}" title="Edit Lowongan"
                                                class="flex h-9 w-9 items-center justify-center
                                                       rounded-lg border border-primary/20
                                                       bg-primary/5 text-primary
                                                       transition-all duration-200
                                                       hover:bg-primary hover:text-white
                                                       hover:shadow-sm">
                                                <span class="material-symbols-outlined text-[18px]">
                                                    edit
                                                </span>
                                            </a>

                                            <!-- Hapus -->
                                            <form action="{{ route('admin_pt.lowongan.destroy', $job->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')"
                                                class="inline m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Lowongan"
                                                    class="flex h-9 w-9 items-center justify-center
                                                           rounded-lg border border-red-200
                                                           bg-red-50 text-red-500
                                                           transition-all duration-200
                                                           hover:bg-red-500 hover:text-white
                                                           hover:shadow-sm">
                                                    <span class="material-symbols-outlined text-[18px]">
                                                        delete
                                                    </span>
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <!-- Empty State -->
                                <tr>
                                    <td colspan="5" class="px-6 py-16">

                                        <div class="flex flex-col items-center justify-center text-center">

                                            <div
                                                class="flex h-16 w-16 items-center justify-center
                                                       rounded-2xl bg-surface-container">

                                                <span class="material-symbols-outlined text-[34px] text-secondary/50">
                                                    work_off
                                                </span>

                                            </div>

                                            <h3 class="mt-4 font-semibold text-on-surface">
                                                Belum ada lowongan
                                            </h3>

                                            <p class="mt-1 max-w-sm text-xs leading-relaxed text-secondary">
                                                Belum ada lowongan pekerjaan yang dibuat.
                                                Silakan buat lowongan pertama Anda melalui tombol
                                                <span class="font-semibold">Buat Lowongan Baru</span>.
                                            </p>

                                        </div>

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>


                <!-- Pagination -->
                @if (isset($lowongans) && method_exists($lowongans, 'links'))
                    <div class="border-t border-surface-container px-6 py-4">
                        {{ $lowongans->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
