<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mitra Perusahaan (Admin PT) - Luang.In</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#fcf9f8] font-sans antialiased text-gray-800 min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-xl bg-white rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-gray-100 p-8 sm:p-10 my-8">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#6b21a8] text-white shadow-md mb-4">
                <span class="material-symbols-outlined text-[28px]">domain</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Pendaftaran Mitra Perusahaan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1.5">
                Daftarkan perusahaan Anda untuk mulai merekrut tenaga kerja serabutan harian
            </p>
        </div>

        <!-- Notifikasi Error Validasi -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs sm:text-sm shadow-sm flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-red-500 shrink-0 mt-0.5">error</span>
                <div class="space-y-1">
                    <p class="font-bold">Mohon perbaiki data berikut:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Banner Informasi Alur Verifikasi Superadmin -->
        <div class="mb-6 p-4 rounded-2xl bg-[#f5f3ff] border border-purple-100 text-xs sm:text-sm text-gray-700 flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-[#7c3aed] text-[22px] shrink-0 mt-0.5">verified_user</span>
            <div class="leading-relaxed">
                <strong class="font-bold text-gray-900">Alur Verifikasi Superadmin:</strong>
                Akun yang didaftarkan akan berstatus <span class="font-bold text-[#6b21a8]">Menunggu Persetujuan (ACC)</span> dan perlu diverifikasi terlebih dahulu oleh Superadmin sebelum dapat digunakan untuk login.
            </div>
        </div>

        <!-- Form Pendaftaran PT -->
        <form action="{{ route('register.pt.process') }}" method="POST" class="space-y-5">
            @csrf

            <!-- 1. Nama Perusahaan -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                    Nama Perusahaan / PT <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                        corporate_fare
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="contoh: PT Maju Bersama Logistik"
                           class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                </div>
            </div>

            <!-- 2. Email Resmi Perusahaan -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                    Email Resmi Perusahaan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                        mail
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="admin@perusahaan.com"
                           class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                </div>
            </div>

            <!-- 3. Nomor WhatsApp Resmi -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                    Nomor WhatsApp Resmi PT <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                        chat
                    </span>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required
                           placeholder="08xxxxxxxxxx atau 628xxxxxxxxxx"
                           class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                </div>
                <p class="text-[11px] text-gray-400 mt-1">Nomor ini akan digunakan untuk koordinasi penjemputan pekerja.</p>
            </div>

            <!-- 4. Domisili / Wilayah Operasional -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                    Kota / Domisili Operasional <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                        location_on
                    </span>
                    <input type="text" name="domisili" value="{{ old('domisili') }}" required
                           placeholder="contoh: Surabaya, Jawa Timur"
                           class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                </div>
            </div>

            <!-- 5. Password & Konfirmasi Password (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                            lock
                        </span>
                        <input type="password" id="regPassword" name="password" required minlength="6"
                               placeholder="Min. 6 karakter"
                               class="w-full pl-11 pr-11 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                        <button type="button" onclick="togglePassword('regPassword', 'regPasswordIcon')"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition focus:outline-none flex items-center justify-center p-0.5"
                                title="Tampilkan / Sembunyikan Password">
                            <span id="regPasswordIcon" class="material-symbols-outlined text-[20px]">
                                visibility
                            </span>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                            lock_reset
                        </span>
                        <input type="password" id="regPasswordConfirm" name="password_confirmation" required minlength="6"
                               placeholder="Ulangi password"
                               class="w-full pl-11 pr-11 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                        <button type="button" onclick="togglePassword('regPasswordConfirm', 'regPasswordConfirmIcon')"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition focus:outline-none flex items-center justify-center p-0.5"
                                title="Tampilkan / Sembunyikan Konfirmasi Password">
                            <span id="regPasswordConfirmIcon" class="material-symbols-outlined text-[20px]">
                                visibility
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                    class="w-full mt-2 py-3.5 px-4 rounded-xl bg-[#6b21a8] hover:bg-[#581c87] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Daftar Menjadi Mitra PT</span>
            </button>
        </form>

        <!-- Footer / Tautan Login -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs sm:text-sm text-gray-500">
                Sudah memiliki akun terverifikasi? 
                <a href="{{ route('login') }}" class="font-bold text-[#6b21a8] hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>

    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerText = 'visibility_off';
            } else {
                input.type = 'password';
                icon.innerText = 'visibility';
            }
        }
    </script>
</body>

</html>

