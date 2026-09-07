<header class="fixed top-0 left-[260px] right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40">
    <div class="w-full h-full px-6 flex items-center justify-between">
        <span class="font-semibold text-on-surface">@yield('header-title', 'Dashboard Perusahaan')</span>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:flex flex-col">
                <span class="text-sm font-semibold text-on-surface">{{ auth()->user()->name ?? 'Perusahaan' }}</span>
                <span class="text-xs text-secondary">{{ auth()->user()->email ?? 'hrd@perusahaan.com' }}</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold text-sm">
                {{ substr(auth()->user()->name ?? 'P', 0, 1) }}
            </div>
        </div>
    </div>
</header>