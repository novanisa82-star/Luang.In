<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Superadmin - LuangIn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Superadmin</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Logout</button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Verifikasi PT -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Daftar Akun PT Menunggu Verifikasi</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama / PT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email / WhatsApp</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pendingPT as $pt)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pt->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pt->email }} / {{ $pt->whatsapp }}</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <form action="{{ route('superadmin.pt.verif', $pt->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="terverifikasi">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Terima</button>
                                </form>
                                <form action="{{ route('superadmin.pt.verif', $pt->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada pengajuan PT baru saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Moderasi Pekerjaan -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Moderasi Lowongan Pekerjaan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Loker</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Upah / Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pendingPekerjaan as $job)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $job->judul }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ $job->upah }} / {{ $job->durasi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <form action="{{ route('superadmin.pekerjaan.moderasi', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_moderasi" value="disetujui">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Setujui</button>
                                </form>
                                <form action="{{ route('superadmin.pekerjaan.moderasi', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_moderasi" value="ditolak">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada lowongan baru yang perlu dimoderasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>