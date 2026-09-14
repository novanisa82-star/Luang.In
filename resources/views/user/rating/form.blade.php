<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beri Rating PT — Luang.In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .star-input input[type="radio"] { display: none; }
        .star-input label { cursor: pointer; font-size: 2.5rem; color: #d1d5db; transition: color 0.15s; }
        .star-input label:hover,
        .star-input label:hover ~ label,
        .star-input input[type="radio"]:checked ~ label { color: #f59e0b; }
        /* Reverse order trick for pure CSS star highlight */
        .star-input { display: flex; flex-direction: row-reverse; justify-content: center; gap: 0.25rem; }
        .star-input label:hover,
        .star-input label:hover ~ label { color: #f59e0b; }
        .star-input input[type="radio"]:checked ~ label { color: #f59e0b; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2">
                <span class="w-9 h-9 rounded-xl bg-[#6b21a8] flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-[20px]">work</span>
                </span>
                <span class="text-xl font-extrabold text-gray-900 tracking-tight">Luang<span class="text-[#7c3aed]">.In</span></span>
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-[0_4px_24px_rgba(0,0,0,0.06)] overflow-hidden">

            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-[#6b21a8] to-[#7c3aed] px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-white text-[24px]">star</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold text-white leading-tight">Beri Rating Perusahaan</h1>
                        <p class="text-purple-200 text-xs mt-0.5">Bagikan pengalaman kerja Anda</p>
                    </div>
                </div>
            </div>

            <div class="px-8 py-6 space-y-6">

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-emerald-600 shrink-0">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[20px] text-red-500 shrink-0">error</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Info Pekerjaan --}}
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                    <span class="text-[10px] font-extrabold tracking-widest text-gray-400 uppercase block mb-2">Pekerjaan</span>
                    <h3 class="font-bold text-gray-900 text-base leading-snug">
                        {{ $application->pekerjaan->judul ?? 'Pekerjaan Serabutan' }}
                    </h3>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-purple-100 text-[#6b21a8] text-[11px] font-semibold">
                            <span class="material-symbols-outlined text-[13px]">business</span>
                            {{ $application->pekerjaan->user->name ?? 'PT' }}
                        </span>
                        @if($application->pekerjaan->durasi)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[11px] font-semibold">
                                <span class="material-symbols-outlined text-[13px]">schedule</span>
                                {{ $application->pekerjaan->durasi }}
                            </span>
                        @endif
                    </div>
                </div>

                @if ($sudahDinilai)
                    {{-- Sudah dinilai --}}
                    <div class="py-8 text-center space-y-3">
                        <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center mx-auto">
                            <span class="material-symbols-outlined text-amber-500 text-[36px]">star</span>
                        </div>
                        <h3 class="font-extrabold text-gray-900 text-lg">Rating Sudah Diberikan</h3>
                        <p class="text-sm text-gray-500 max-w-xs mx-auto leading-relaxed">
                            Anda sudah memberikan rating untuk pekerjaan ini. Terima kasih atas masukan Anda!
                        </p>
                    </div>
                @else
                    {{-- Form Rating --}}
                    <form action="{{ route('user.rating.store', $application->id) }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Pilih Bintang --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-3 text-center">
                                Berapa bintang untuk perusahaan ini?
                            </label>
                            <div class="star-input" id="starRating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="bintang" id="star{{ $i }}" value="{{ $i }}"
                                        {{ old('bintang') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" title="{{ $i }} Bintang">★</label>
                                @endfor
                            </div>
                            @error('bintang')
                                <p class="text-xs text-red-600 text-center mt-2">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 text-center mt-2" id="starLabel">Klik bintang untuk memberi penilaian</p>
                        </div>

                        {{-- Komentar --}}
                        <div>
                            <label for="komentar" class="block text-sm font-bold text-gray-800 mb-1.5">
                                Komentar <span class="text-gray-400 font-normal">(Opsional)</span>
                            </label>
                            <textarea id="komentar" name="komentar" rows="4"
                                placeholder="Ceritakan pengalaman kerja Anda di perusahaan ini..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition resize-none">{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full py-3 rounded-xl bg-[#6b21a8] hover:bg-[#581c87] text-white font-bold text-sm shadow-md transition">
                            Kirim Rating
                        </button>
                    </form>
                @endif

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            Rating Anda membantu pekerja lain memilih perusahaan yang tepat.
        </p>
    </div>

    <script>
        const labels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
        const starInputs = document.querySelectorAll('#starRating input[type="radio"]');
        const starLabel = document.getElementById('starLabel');
        starInputs.forEach(input => {
            input.addEventListener('change', function () {
                if (starLabel) starLabel.textContent = labels[this.value] + ' (' + this.value + ' Bintang)';
            });
        });
    </script>

</body>
</html>

