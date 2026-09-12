<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal Admin & Mitra PT - Luang.In</title>
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
    <div class="w-full max-w-md bg-white rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-gray-100 p-8 sm:p-10 my-8">
        
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#6b21a8] text-white shadow-md mb-4">
                <span class="material-symbols-outlined text-[28px]">deployed_code</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Portal Admin & PT
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1.5">
                Masuk untuk mengelola lowongan dan rekrutmen pekerja
            </p>
        </div>

        <!-- Notifikasi Sukses Pendaftaran -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm shadow-sm flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-emerald-600 shrink-0 mt-0.5">check_circle</span>
                <span class="leading-relaxed font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Notifikasi Error Login / Menunggu ACC -->
        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm shadow-sm flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-amber-600 shrink-0 mt-0.5">warning</span>
                <span class="leading-relaxed font-semibold">{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                    Alamat Email <span class="text-red-500">*</span>
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

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs sm:text-sm font-bold text-gray-800">
                        Password <span class="text-red-500">*</span>
                    </label>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">
                        lock
                    </span>
                    <input type="password" id="loginPassword" name="password" required
                           placeholder="••••••••"
                           class="w-full pl-11 pr-11 py-3 rounded-xl bg-gray-50 border border-gray-200 text-sm text-gray-900 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-600 transition">
                    <button type="button" onclick="togglePassword('loginPassword', 'loginPasswordIcon')"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition focus:outline-none flex items-center justify-center p-0.5"
                            title="Tampilkan / Sembunyikan Password">
                        <span id="loginPasswordIcon" class="material-symbols-outlined text-[20px]">
                            visibility
                        </span>
                    </button>
                </div>
            </div>

            <!-- Tombol Masuk -->
            <button type="submit"
                    class="w-full mt-2 py-3.5 px-4 rounded-xl bg-[#6b21a8] hover:bg-[#581c87] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">login</span>
                <span>Masuk Dashboard</span>
            </button>
        </form>

        <!-- Footer / Tautan Daftar PT -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                Ingin merekrut pekerja serabutan? <br>
                <a href="{{ route('register.pt') }}" class="font-bold text-[#6b21a8] hover:underline inline-flex items-center gap-1 mt-1">
                    <span>Daftar Menjadi Mitra PT</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
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