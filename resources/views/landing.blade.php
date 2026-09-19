<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Luang.In — Portal Kerja Serabutan & Rekrutmen Harian</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    
    <!-- AOS (Animate On Scroll) Library CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#630ed4",
                        "primary-hover": "#4c09a8",
                        "purple-light": "#f5f3ff",
                        "purple-border": "#ede9fe",
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: floatSlow 4s ease-in-out infinite;
        }
        .card-hover-effect {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-hover-effect:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -10px rgba(99, 14, 212, 0.12), 0 8px 16px -6px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-[#fcf9f8] font-sans antialiased text-gray-800 selection:bg-purple-200 selection:text-purple-900">

    <!-- Flash Message Logout / Notification -->
    @if(session('success'))
        <div class="bg-emerald-600 text-white px-4 py-3 text-center text-xs font-bold shadow-md flex items-center justify-center gap-2 animate-fade-in">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- 1. NAVBAR / HEADER UTAMA -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200/80 transition-all">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            
            <!-- Logo Brand -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#581c87] to-[#7c3aed] text-white flex items-center justify-center shadow-md shadow-purple-600/20 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-[24px]">work</span>
                </div>
                <div>
                    <span class="font-black text-xl text-gray-900 tracking-tight block leading-none">
                        Luang<span class="text-[#7c3aed]">.In</span>
                    </span>
                    <span class="text-[11px] font-bold text-gray-400 block mt-0.5">Kerja Serabutan &amp; Harian</span>
                </div>
            </a>

            <!-- Menu Navigasi Tengah (Desktop) -->
            <nav class="hidden md:flex items-center gap-8 text-xs font-bold text-gray-600">
                <a href="#beranda" class="hover:text-[#7c3aed] transition">Beranda</a>
                <a href="#pintu-masuk" class="hover:text-[#7c3aed] transition">Pilihan Portal</a>
                <a href="#fitur" class="hover:text-[#7c3aed] transition">Fitur Unggulan</a>
                <a href="#lowongan" class="hover:text-[#7c3aed] transition">Lowongan Terkini</a>
                <a href="#faq" class="hover:text-[#7c3aed] transition">Bantuan / FAQ</a>
            </nav>

            <!-- Tombol Aksi Akses (Login & Register PT dengan Modern Hover Animation) -->
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 bg-white hover:border-purple-300 hover:text-purple-900 transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5 flex items-center gap-1.5 group">
                    <span class="material-symbols-outlined text-[18px] text-gray-500 group-hover:text-purple-600 group-hover:scale-110 transition-transform">login</span>
                    <span>Masuk / Login</span>
                </a>

                <a href="{{ route('register.pt') }}"
                   class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#7c3aed] to-[#6b21a8] hover:from-[#6b21a8] hover:to-[#581c87] text-white text-xs font-bold transition-all duration-300 shadow-md shadow-purple-600/30 hover:shadow-lg hover:shadow-purple-600/40 hover:-translate-y-0.5 flex items-center gap-1.5 group">
                    <span class="material-symbols-outlined text-[18px] group-hover:rotate-12 transition-transform">domain_add</span>
                    <span>Daftar Mitra PT</span>
                </a>
            </div>

        </div>
    </header>

    <!-- 2. HERO SECTION DENGAN AOS ANIMATION -->
    <section id="beranda" class="relative overflow-hidden py-16 lg:py-24 bg-gradient-to-b from-purple-50/50 to-transparent">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Sisi Kiri: Headline & Call To Action (AOS Fade Right) -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left" data-aos="fade-right" data-aos-duration="800">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-100 text-[#6b21a8] text-xs font-bold border border-purple-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                    <span>Platform Rekrutmen Harian #1 Indonesia</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-gray-900 tracking-tight leading-[1.15]">
                    Solusi Kerja Serabutan &amp; Tenaga Lapangan <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#6b21a8] to-[#7c3aed]">Cepat &amp; Terpercaya</span>
                </h1>

                <p class="text-sm sm:text-base text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Menghubungkan Perusahaan Mitra (PT) dengan pekerja lepas harian dalam hitungan menit. Dilengkapi koordinasi WhatsApp otomatis, pelacakan lokasi presisi, dan moderasi Superadmin yang aman.
                </p>

                <!-- Action Button Group dengan Animasi Hover Interaktif -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('register.pt') }}"
                       class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-[#6b21a8] to-[#7c3aed] hover:from-[#581c87] hover:to-[#6b21a8] text-white text-sm font-extrabold shadow-lg shadow-purple-900/30 hover:shadow-xl hover:shadow-purple-900/40 hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center gap-2 group">
                        <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">add_business</span>
                        <span>Daftarkan Perusahaan (PT)</span>
                    </a>

                    <a href="{{ route('login') }}"
                       class="px-6 py-3.5 rounded-2xl bg-white border border-gray-200/90 text-gray-800 hover:text-[#6b21a8] hover:border-purple-300 hover:bg-purple-50/40 text-sm font-extrabold shadow-sm hover:shadow-md hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center gap-2 group">
                        <span class="material-symbols-outlined text-[20px] text-purple-700 group-hover:scale-110 transition-transform">lock_open</span>
                        <span>Masuk ke Akun</span>
                    </a>

                    <a href="{{ route('admin_pt.dashboard') }}"
                       class="px-4 py-3.5 rounded-2xl bg-gradient-to-r from-amber-50 to-amber-100/80 hover:from-amber-100 hover:to-amber-200 border border-amber-300/80 text-amber-950 text-xs font-extrabold shadow-sm hover:shadow-md hover:-translate-y-1 active:translate-y-0 transition-all duration-300 flex items-center gap-1.5 group"
                       title="Panel Moderasi Superadmin">
                        <span class="material-symbols-outlined text-[18px] text-amber-600 group-hover:rotate-12 transition-transform">shield_person</span>
                        <span>Portal Superadmin</span>
                    </a>
                </div>

                <!-- Keunggulan Singkat -->
                <div class="pt-6 border-t border-gray-200/80 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-gray-500 font-medium">
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px]">verified</span>
                        <span>Verifikasi Superadmin</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-purple-600 text-[18px]">chat</span>
                        <span>Instant WA Connection</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-amber-500 text-[18px]">star</span>
                        <span>Rating Per Lowongan</span>
                    </span>
                </div>
            </div>

            <!-- Sisi Kanan: Kartu Visual (AOS Zoom In & Float) -->
            <div class="lg:col-span-5 relative" data-aos="zoom-in-up" data-aos-duration="900" data-aos-delay="150">
                <div class="bg-white rounded-3xl border border-gray-200/90 shadow-[0_8px_30px_rgba(0,0,0,0.06)] p-6 space-y-5 relative animate-float">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-[#6b21a8] flex items-center justify-center font-bold text-xs">
                                PT
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-gray-900">PT Logistik Nusantara</h4>
                                <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Terverifikasi Superadmin
                                </span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200/60">
                            4.9 ★
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div class="p-3.5 rounded-2xl bg-purple-50/70 border border-purple-100">
                            <span class="text-[10px] font-bold text-purple-700 uppercase tracking-wider block">Lowongan Aktif</span>
                            <h5 class="font-extrabold text-gray-900 text-sm mt-0.5">Bongkar Muat Gudang &amp; Logistik</h5>
                            <div class="flex items-center justify-between mt-2 text-xs">
                                <span class="font-bold text-emerald-700">Rp 175.000 / Shift</span>
                                <span class="text-gray-500">Durasi: 1 Hari</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs text-gray-600 font-medium">
                                <span class="material-symbols-outlined text-purple-600 text-[18px]">group</span>
                                <span>12 Pelamar Masuk</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                                4 Diterima
                            </span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('login') }}" class="w-full py-2.5 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-bold transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-md hover:-translate-y-0.5 group">
                            <span>Masuk ke Portal Perusahaan</span>
                            <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- 3. CARDS METRIK / COUNTER BAR (AOS Fade Up) -->
    <section class="py-8 bg-white border-y border-gray-200/80">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="p-3 rounded-2xl hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-2xl sm:text-3xl font-black text-gray-900">500+</h3>
                <p class="text-xs text-gray-500 font-semibold mt-1">Mitra Perusahaan (PT)</p>
            </div>
            <div class="p-3 rounded-2xl hover:bg-purple-50/50 transition" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-2xl sm:text-3xl font-black text-[#7c3aed]">10,000+</h3>
                <p class="text-xs text-gray-500 font-semibold mt-1">Pekerja Lapangan Siap Penugasan</p>
            </div>
            <div class="p-3 rounded-2xl hover:bg-emerald-50/50 transition" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-2xl sm:text-3xl font-black text-emerald-600">98.4%</h3>
                <p class="text-xs text-gray-500 font-semibold mt-1">Tingkat Hadir &amp; Ketepatan Waktu</p>
            </div>
            <div class="p-3 rounded-2xl hover:bg-amber-50/50 transition" data-aos="fade-up" data-aos-delay="400">
                <h3 class="text-2xl sm:text-3xl font-black text-amber-500">4.9 / 5</h3>
                <p class="text-xs text-gray-500 font-semibold mt-1">Rating Kepuasan Rekrutmen</p>
            </div>
        </div>
    </section>

    <!-- 4. PINTU MASUK DENGAN AOS STAGGERED FADE-UP -->
    <section id="pintu-masuk" class="py-16 max-w-7xl mx-auto px-6 space-y-10">
        <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
            <span class="text-xs font-extrabold text-[#7c3aed] uppercase tracking-wider block mb-2">PILIHAN AKSES MULTI-PERAN</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Pilih Portal Sesuai Peran Anda</h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 leading-relaxed">
                Akses mudah dan disesuaikan untuk Perusahaan Mitra, Pencari Kerja, serta Panel Pengawasan Superadmin.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card Portal 1: Mitra PT / Perusahaan -->
            <div class="bg-white rounded-3xl border border-gray-200/90 p-8 shadow-sm card-hover-effect group flex flex-col justify-between space-y-6"
                 data-aos="fade-up" data-aos-delay="100">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-[#6b21a8] flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner">
                        <span class="material-symbols-outlined text-[32px]">domain</span>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-extrabold border border-purple-100 inline-block">
                        Portal Mitra PT
                    </span>

                    <h3 class="text-xl font-extrabold text-gray-900 leading-tight">Perusahaan / Mitra PT</h3>

                    <p class="text-xs text-gray-600 leading-relaxed">
                        Pasang lowongan kerja harian serabutan, tentukan upah &amp; durasi, kelola status pelamar, serta hubungi kandidat via WhatsApp instan.
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-2">
                    <a href="{{ route('register.pt') }}"
                       class="w-full py-3 rounded-xl bg-gradient-to-r from-[#6b21a8] to-[#7c3aed] hover:from-[#581c87] hover:to-[#6b21a8] text-white text-xs font-extrabold transition-all duration-300 shadow-md shadow-purple-900/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        <span>Daftar PT Baru</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                    <a href="{{ route('login') }}"
                       class="w-full py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-bold transition-all duration-300 flex items-center justify-center gap-1.5 hover:-translate-y-0.5">
                        <span>Login Mitra PT</span>
                    </a>
                </div>
            </div>

            <!-- Card Portal 2: Pekerja / Pelamar -->
            <div class="bg-white rounded-3xl border border-gray-200/90 p-8 shadow-sm card-hover-effect group flex flex-col justify-between space-y-6"
                 data-aos="fade-up" data-aos-delay="250">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner">
                        <span class="material-symbols-outlined text-[32px]">badge</span>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-100 inline-block">
                        Portal Pencari Kerja
                    </span>

                    <h3 class="text-xl font-extrabold text-gray-900 leading-tight">Pekerja Serabutan</h3>

                    <p class="text-xs text-gray-600 leading-relaxed">
                        Temukan lowongan kerja harian di dekat lokasi domisili Anda. Kirim lamaran instant, dapatkan instruksi penugasan, dan kumpulkan rating bintang.
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-2">
                    <a href="{{ route('login') }}"
                       class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-xs font-extrabold transition-all duration-300 shadow-md shadow-emerald-700/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        <span>Masuk &amp; Cari Pekerjaan</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:scale-110 transition-transform">search</span>
                    </a>
                </div>
            </div>

            <!-- Card Portal 3: Superadmin Panel -->
            <div class="bg-white rounded-3xl border border-gray-200/90 p-8 shadow-sm card-hover-effect group flex flex-col justify-between space-y-6"
                 data-aos="fade-up" data-aos-delay="400">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center group-hover:scale-110 transition-transform shadow-inner">
                        <span class="material-symbols-outlined text-[32px]">shield_person</span>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold border border-amber-100 inline-block">
                        Panel Moderasi
                    </span>

                    <h3 class="text-xl font-extrabold text-gray-900 leading-tight">Superadmin System</h3>

                    <p class="text-xs text-gray-600 leading-relaxed">
                        Verifikasi identitas pendaftaran PT, moderasi penayangan lowongan kerja baru, serta tindak lanjuti laporan pengaduan operasional.
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100 space-y-2">
                    <a href="{{ route('admin_pt.dashboard') }}"
                       class="w-full py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-extrabold transition-all duration-300 shadow-md shadow-amber-600/20 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        <span>Akses Panel Superadmin</span>
                        <span class="material-symbols-outlined text-[16px] group-hover:scale-110 transition-transform">admin_panel_settings</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- 5. FITUR UNGGULAN SECTION (AOS Zoom In) -->
    <section id="fitur" class="py-16 bg-white border-y border-gray-200/80">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-2" data-aos="fade-up">
                <span class="text-xs font-extrabold text-[#7c3aed] uppercase tracking-wider">MENGAPA MEMILIH LUANG.IN?</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Fitur Canggih Pendukung Rekrutmen</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="p-6 rounded-2xl bg-[#f8f9fa] border border-gray-200/80 space-y-3 card-hover-effect"
                     data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-[#6b21a8] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">location_on</span>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm">Peta Lokasi Leaflet Presisi</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Penentuan titik koordinat tempat kerja berbasis peta Leaflet &amp; Google Maps untuk panduan titik penjemputan pekerja.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-[#f8f9fa] border border-gray-200/80 space-y-3 card-hover-effect"
                     data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">forum</span>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm">Instant WhatsApp Hub</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Link koordinasi WhatsApp otomatis tergenerasi saat status pelamar diubah menjadi DITERIMA untuk kepastian jam kerja.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-[#f8f9fa] border border-gray-200/80 space-y-3 card-hover-effect"
                     data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">star</span>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm">Rating Per Lowongan</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Penilaian ulasan bintang dan umpan balik yang terstruktur secara spesifik untuk masing-masing posisi pekerjaan serabutan.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-[#f8f9fa] border border-gray-200/80 space-y-3 card-hover-effect"
                     data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">security</span>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm">Pengawasan &amp; Moderasi</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Verifikasi ketat oleh Superadmin guna memastikan keamanan hak kerja, legalitas PT, serta bebas dari penipuan.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- 6. LOWONGAN TERKINI PREVIEW (AOS Fade Up) -->
    <section id="lowongan" class="py-16 max-w-7xl mx-auto px-6 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4" data-aos="fade-up">
            <div>
                <span class="text-xs font-extrabold text-[#7c3aed] uppercase tracking-wider block mb-1">LOWONGAN TERBARU</span>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Peluang Kerja Serabutan Aktif</h2>
            </div>
            <a href="{{ route('login') }}" class="text-xs text-purple-700 font-bold hover:underline flex items-center gap-1 group">
                <span>Lihat Semua Lowongan</span>
                <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($lowongans ?? [] as $index => $job)
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm card-hover-effect flex flex-col justify-between space-y-4"
                     data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-100">
                            {{ $job->durasi ?? 'Harian' }}
                        </span>
                        <h4 class="font-bold text-gray-900 text-sm mt-2 line-clamp-1">{{ $job->judul }}</h4>
                        <p class="text-xs text-emerald-700 font-extrabold mt-1">
                            Rp {{ number_format((float)$job->upah, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($job->deskripsi, 80) }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[11px] text-gray-400 font-medium">
                            {{ $job->user->name ?? 'Mitra PT' }}
                        </span>
                        <a href="{{ route('login') }}" class="px-3 py-1.5 rounded-lg bg-gray-900 hover:bg-black text-white text-xs font-bold transition-all duration-200 shadow-sm hover:scale-105">
                            Lamar
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center bg-white rounded-2xl border border-gray-200 text-gray-400 text-xs">
                    Belum ada lowongan pekerjaan publik yang ditayangkan.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 7. FAQ SECTION (AOS Fade Up) -->
    <section id="faq" class="py-16 bg-white border-t border-gray-200/80">
        <div class="max-w-4xl mx-auto px-6 space-y-8">
            <div class="text-center space-y-2" data-aos="fade-up">
                <span class="text-xs font-extrabold text-[#7c3aed] uppercase tracking-wider">PERTANYAAN UMUM</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
            </div>

            <div class="space-y-4">
                <div class="bg-[#f8f9fa] rounded-2xl p-5 border border-gray-200/80 space-y-1 card-hover-effect" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="font-bold text-gray-900 text-sm">Bagaimana cara perusahaan (PT) mulai memasang lowongan?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Perusahaan dapat mendaftar melalui menu <strong class="text-purple-700">Daftar Mitra PT</strong>. Setelah mengisi data dan disetujui (ACC) oleh Superadmin, Anda dapat langsung login dan memasang lowongan kerja harian.
                    </p>
                </div>

                <div class="bg-[#f8f9fa] rounded-2xl p-5 border border-gray-200/80 space-y-1 card-hover-effect" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="font-bold text-gray-900 text-sm">Bagaimana proses verifikasi oleh Superadmin?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Superadmin akan memeriksa kelengkapan data PT dan legalitas operasional. Setelah terverifikasi, PT dapat mengaktifkan akun dan memublikasikan lowongan ke pencari kerja.
                    </p>
                </div>

                <div class="bg-[#f8f9fa] rounded-2xl p-5 border border-gray-200/80 space-y-1 card-hover-effect" data-aos="fade-up" data-aos-delay="300">
                    <h4 class="font-bold text-gray-900 text-sm">Bagaimana koordinasi antara PT dan pekerja yang diterima?</h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Sistem secara otomatis menyediakan tombol WhatsApp resmi yang sudah terformat pesan konfirmasi begitu status lamaran diubah menjadi DITERIMA.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FOOTER -->
    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 text-xs text-gray-400">
            
            <div class="space-y-3 md:col-span-2">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#7c3aed] text-white flex items-center justify-center font-bold">
                        L
                    </div>
                    <span class="font-extrabold text-lg text-white tracking-tight">Luang.In</span>
                </div>
                <p class="leading-relaxed max-w-sm">
                    Platform perantara kerja serabutan dan rekrutmen tenaga kerja harian terpercaya. Menghubungkan kebutuhan operasional perusahaan dengan pekerja lapangan secara efisien.
                </p>
            </div>

            <div class="space-y-2">
                <h4 class="font-bold text-white uppercase text-[11px] tracking-wider">Akses Portal</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Form Login User / PT</a></li>
                    <li><a href="{{ route('register.pt') }}" class="hover:text-white transition">Pendaftaran Mitra PT</a></li>
                    <li><a href="{{ route('admin_pt.dashboard') }}" class="hover:text-white transition">Dashboard Admin PT</a></li>
                    <li><a href="{{ route('admin_pt.dashboard') }}" class="hover:text-white transition">Panel Moderasi Superadmin</a></li>
                </ul>
            </div>

            <div class="space-y-2">
                <h4 class="font-bold text-white uppercase text-[11px] tracking-wider">Kontak &amp; Bantuan</h4>
                <p class="leading-relaxed">
                    Email: support@luang.in<br />
                    Layanan Bantuan 24/7<br />
                    Indonesia
                </p>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-6 pt-8 mt-8 border-t border-gray-800 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Luang.In. Hak Cipta Dilindungi Undang-Undang.
        </div>
    </footer>

    <!-- AOS (Animate On Scroll) JS CDN & Initialization -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init({
                duration: 800,
                easing: 'ease-out-cubic',
                once: true,
                offset: 50
            });
        });
    </script>

</body>

</html>
