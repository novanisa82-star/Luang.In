<aside
    class="fixed left-0 top-0 h-full w-[260px] bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
    <div class="flex flex-col">
        <div class="h-16 px-6 flex items-center">
            <div>
                <span class="font-bold text-lg text-on-surface leading-tight">LuangIn PT</span>
                <span class="block text-xs text-secondary font-medium">Portal Perusahaan</span>
            </div>
        </div>
        <div class="px-4 py-2">
            <nav class="flex flex-col gap-1">
                <!-- Menu Beranda -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin_pt.dashboard') ? 'bg-secondary-fixed text-primary font-semibold' : 'text-secondary hover:bg-surface-container-low hover:text-on-surface font-medium' }} rounded-xl"
                    href="{{ route('admin_pt.dashboard') }}">
                    <span class="material-symbols-outlined text-[20px]">grid_view</span><span>Beranda</span>
                </a>

                <!-- Menu Kelola Lowongan -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin_pt.lowongan*') ? 'bg-secondary-fixed text-primary font-semibold' : 'text-secondary hover:bg-surface-container-low hover:text-on-surface font-medium' }} rounded-xl"
                    href="{{ route('admin_pt.lowongan.index') }}">
                    <span class="material-symbols-outlined text-[20px]">work</span><span>Kelola Lowongan</span>
                </a>

                <!-- Menu Pelamar Masuk -->
                <a class="flex items-center gap-3 px-4 py-3 transition-all {{ request()->routeIs('admin_pt.pelamar*') ? 'bg-secondary-fixed text-primary font-semibold' : 'text-secondary hover:bg-surface-container-low hover:text-on-surface font-medium' }} rounded-xl"
                    href="#">
                    <span class="material-symbols-outlined text-[20px]">group</span><span>Pelamar Masuk</span>
                </a>
            </nav>
        </div>
    </div>
    <div class="p-4 mb-2">
        <div class="p-3 bg-surface-container-low rounded-xl flex items-center justify-between">
            <div>
                <span class="block text-[11px] text-secondary">Status PT</span>
                <span class="text-xs text-tertiary font-medium flex items-center gap-1"><span
                        class="w-2 h-2 rounded-full bg-tertiary-fixed-dim inline-block"></span> Terverifikasi</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline m-0 p-0">
                @csrf
                <button type="submit" title="Keluar"
                    class="text-secondary hover:text-red-600 transition-all flex items-center justify-center p-1 rounded-lg hover:bg-surface-container">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
