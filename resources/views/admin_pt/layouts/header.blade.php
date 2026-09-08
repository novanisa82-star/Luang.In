<header class="fixed top-0 left-[260px] right-0 h-16 bg-white/95 backdrop-blur-md border-b border-gray-100 z-40">
    <div class="w-full h-full px-8 flex items-center justify-between">

        <!-- Sisi Kiri: Logo & Nama Perusahaan -->
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-[#6b21a8] text-white flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-[18px]">deployed_code</span>
            </div>
            <span class="font-bold text-gray-900 text-sm sm:text-base">
                {{ auth()->user()->name ?? 'PT Maju Bersama Serabutan' }}
            </span>
        </div>

        <!-- Sisi Kanan: Status Terverifikasi & Profil Akun -->
        <div class="flex items-center gap-4">
            <!-- Badge Terverifikasi Resmi -->
            <div
                class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white border border-gray-200 text-xs font-semibold text-gray-700 shadow-sm">
                <span class="material-symbols-outlined text-gray-600 text-[16px]">verified</span>
                <span>Terverifikasi Resmi</span>
            </div>

            <!-- Akun Pengguna -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden md:flex flex-col">
                    <span class="text-xs font-bold text-gray-900 leading-tight">
                        {{ auth()->user()->name ?? 'PT Maju Bersama Serabutan' }}
                    </span>
                    <span class="text-[11px] text-gray-400 font-medium">Admin Ketenagakerjaan</span>
                </div>
                <div
                    class="w-9 h-9 rounded-full bg-[#5b21b6] text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>
            </div>
        </div>

    </div>
</header>
