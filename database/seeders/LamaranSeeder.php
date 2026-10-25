<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Application;
use Carbon\Carbon;

class LamaranSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil akun pelamar dan lowongan yang sudah tersedia.
        // Ganti ID ini dengan ID akun pelamar yang kamu gunakan untuk login.
        $pelamarId = 20;

        $pelamar = User::find($pelamarId);

        if (!$pelamar) {
            $this->command->error(
                "User dengan ID {$pelamarId} tidak ditemukan."
            );
            return;
        }

        $pekerjaanList = Pekerjaan::query()
            ->orderBy('id')
            ->take(3)
            ->get();

        if ($pekerjaanList->isEmpty()) {
            $this->command->error(
                'Belum ada data pekerjaan. Buat lowongan terlebih dahulu.'
            );
            return;
        }

        $statusList = [
            [
                'status' => 'menunggu',
                'hari' => 0,
            ],
            [
                'status' => 'diterima',
                'hari' => 1,
            ],
            [
                'status' => 'ditolak',
                'hari' => 2,
            ],
        ];

        foreach ($statusList as $index => $item) {
            $pekerjaan = $pekerjaanList[$index % $pekerjaanList->count()];

            Application::create([
                'user_id' => $pelamar->id,
                'pekerjaan_id' => $pekerjaan->id,
                'status' => $item['status'],
                'created_at' => Carbon::now()->subDays($item['hari']),
                'updated_at' => Carbon::now(),
            ]);
        }

        $this->command->info(
            'Seeder riwayat lamaran berhasil dijalankan.'
        );
    }
}
