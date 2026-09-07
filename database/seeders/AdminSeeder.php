<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Superadmin
        User::create([
            'name' => 'Superadmin LuangIn',
            'email' => 'superadmin@luangin.com',
            'whatsapp' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        // Membuat akun Admin PT
        User::create([
            'name' => 'Admin PT Contoh',
            'email' => 'adminpt@luangin.com',
            'whatsapp' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'admin_pt',
            'status_verifikasi_pt' => 'menunggu'
        ]);
        User::create([
            'name' => 'PT Faldy Ardiansyah',
            'email' => 'faldy@gmail.com',
            'whatsapp' => '0812316375856',
            'password' => Hash::make('password123'),
            'role' => 'admin_pt',
            'status_verifikasi_pt' => 'menunggu'
        ]);
    }
}