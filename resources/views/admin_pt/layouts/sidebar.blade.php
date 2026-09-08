<aside
    class="fixed left-0 top-0 h-full w-[260px] bg-white z-50 flex flex-col justify-between shadow-[0_1px_10px_rgba(0,0,0,0.03)] border-r border-gray-100">
    <div class="flex flex-col">
        <!-- Logo Brand -->
        <div class="h-20 px-6 flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-xl bg-[#6b21a8] text-white flex items-center justify-center shadow-sm shrink-0">
                <span class="material-symbols-outlined text-[24px]">deployed_code</span>
            </div>
            <div>
                <span class="font-extrabold text-base text-gray-900 leading-tight block">Kerja Serabutan</span>
                <span class="block text-[11px] text-gray-400 font-semibold">Portal Admin PT</span>
            </div>
        </div>

        <!-- Navigation -->
        <div class="px-4 py-2">
            <nav class="flex flex-col gap-1.5">
                <!-- Menu Beranda -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all rounded-xl {{ request()->routeIs('admin_pt.dashboard') ? 'bg-[#ede9fe] text-[#6b21a8] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}"
                    href="{{ route('admin_pt.dashboard') }}">
                    <span class="material-symbols-outlined text-[22px]">grid_view</span>
                    <span class="text-sm">Beranda</span>
                </a>

                <!-- Menu Lowongan Saya -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all rounded-xl {{ request()->routeIs('admin_pt.lowongan*') ? 'bg-[#ede9fe] text-[#6b21a8] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}"
                    href="{{ route('admin_pt.lowongan.index') }}">
                    <span class="material-symbols-outlined text-[22px]">work_outline</span>
                    <span class="text-sm">Lowongan Saya</span>
                </a>

                <!-- Menu Pelamar -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all rounded-xl {{ request()->routeIs('admin_pt.pelamar*') ? 'bg-[#ede9fe] text-[#6b21a8] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}"
                    href="#">
                    <span class="material-symbols-outlined text-[22px]">group</span>
                    <span class="text-sm">Pelamar</span>
                </a>

                <!-- Menu Riwayat -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all rounded-xl {{ request()->routeIs('admin_pt.riwayat*') ? 'bg-[#ede9fe] text-[#6b21a8] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }}"
                    href="#">
                    <span class="material-symbols-outlined text-[22px]">history</span>
                    <span class="text-sm">Riwayat</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Status Sistem & Tombol Logout -->
    <div class="p-4 mb-2">
        <div class="p-3.5 bg-[#f8f9fa] border border-gray-200/80 rounded-2xl flex items-center justify-between">
            <div>
                <span class="block text-[11px] text-gray-400 font-medium">Status Sistem</span>
                <span class="text-xs text-gray-800 font-semibold flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                    Aktif
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" title="Bantuan" class="text-gray-400 hover:text-gray-600 transition">
                    <span class="material-symbols-outlined text-[20px]">help</span>
                </button>
                <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                    @csrf
                    <button type="submit" title="Keluar"
                        class="text-gray-400 hover:text-red-600 transition flex items-center justify-center p-1 rounded-lg hover:bg-gray-100">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
