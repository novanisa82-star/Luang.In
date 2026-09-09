<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;

class PelamarSeeder extends Seeder
{
    public function run(): void
    {
        // Cari atau buat Admin PT Maju Bersama Serabutan
        $adminPt = User::where('email', 'adminpt@luangin.com')->first();
        if (!$adminPt) {
            $adminPt = User::create([
                'name' => 'PT Maju Bersama Serabutan',
                'email' => 'adminpt@luangin.com',
                'whatsapp' => '081234567892',
                'password' => Hash::make('password123'),
                'role' => 'admin_pt',
                'domisili' => 'Surabaya',
                'status_verifikasi_pt' => 'terverifikasi'
            ]);
        } else {
            $adminPt->update([
                'name' => 'PT Maju Bersama Serabutan',
                'status_verifikasi_pt' => 'terverifikasi'
            ]);
        }

        // Cari atau buat Lowongan "Tenaga Angkut Gudang Harian"
        $lowongan = Pekerjaan::firstOrCreate(
            [
                'user_id' => $adminPt->id,
                'judul' => 'Tenaga Angkut Gudang Harian',
            ],
            [
                'deskripsi' => "Dibutuhkan tenaga bongkar muat dan angkut barang logistik pergudangan harian. Kondisi fisik prima, siap kerja tim, dan jujur.\n\nLokasi: Rungkut Industri Raya No. 45, Surabaya\nSkill yang dibutuhkan: Bongkar Muat, Fisik Prima, Logistik Gudang",
                'latitude' => -7.320000,
                'longitude' => 112.760000,
                'upah' => '150000',
                'durasi' => 'Shift Pagi (07.00 - 15.00)',
                'status_moderasi' => 'disetujui',
                'status_loker' => 'aktif',
            ]
        );

        // Data pelamar prioritas persis seperti di mockup
        $pelamars = [
            [
                'name' => 'Budi Prasetyo',
                'email' => 'budi.prasetyo@gmail.com',
                'whatsapp' => '081234567801',
                'domisili' => 'Rungkut',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Agus Santoso',
                'email' => 'agus.santoso@gmail.com',
                'whatsapp' => '081234567802',
                'domisili' => 'Wonokromo',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Rian Wahyudi',
                'email' => 'rian.wahyudi@gmail.com',
                'whatsapp' => '081234567803',
                'domisili' => 'Sukolilo',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Deni Pratama',
                'email' => 'deni.pratama@gmail.com',
                'whatsapp' => '081234567804',
                'domisili' => 'Sawahan',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti.rahma@gmail.com',
                'whatsapp' => '081234567805',
                'domisili' => 'Gubeng',
                'status' => 'diterima',
            ],
            [
                'name' => 'Eko Prasetya',
                'email' => 'eko.prasetya@gmail.com',
                'whatsapp' => '081234567806',
                'domisili' => 'Wonocolo',
                'status' => 'diterima',
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@gmail.com',
                'whatsapp' => '081234567807',
                'domisili' => 'Tegalsari',
                'status' => 'diterima',
            ],
            [
                'name' => 'Bayu Aditya',
                'email' => 'bayu.aditya@gmail.com',
                'whatsapp' => '081234567808',
                'domisili' => 'Tambaksari',
                'status' => 'diterima',
            ],
            [
                'name' => 'Dimas Saputra',
                'email' => 'dimas.saputra@gmail.com',
                'whatsapp' => '081234567809',
                'domisili' => 'Kenjeran',
                'status' => 'ditolak',
            ],
            [
                'name' => 'Wahyu Hidayat',
                'email' => 'wahyu.hidayat@gmail.com',
                'whatsapp' => '081234567810',
                'domisili' => 'Jambangan',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Arif Rahman',
                'email' => 'arif.rahman@gmail.com',
                'whatsapp' => '081234567811',
                'domisili' => 'Sukomanunggal',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@gmail.com',
                'whatsapp' => '081234567812',
                'domisili' => 'Wiyung',
                'status' => 'menunggu',
            ],
        ];

        foreach ($pelamars as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'whatsapp' => $data['whatsapp'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                    'domisili' => $data['domisili'],
                ]
            );

            Application::firstOrCreate(
                [
                    'pekerjaan_id' => $lowongan->id,
                    'user_id' => $user->id,
                ],
                [
                    'status' => $data['status'],
                ]
            );
        }
    }
}

