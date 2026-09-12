<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function terlapor()
    {
        return $this->belongsTo(User::class, 'terlapor_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    // Helper teks label kategori
    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'penipuan_loker' => 'Dugaan Penipuan Loker',
            'upah_tidak_sesuai' => 'Upah Tidak Sesuai Kesepakatan',
            'pelanggaran_sop' => 'Pelanggaran SOP / Perilaku Tidak Pantas',
            'kontak_palsu' => 'Kontak / Identitas Palsu',
            'pekerja_mangkir' => 'Pekerja Mangkir / Tidak Hadir',
            default => 'Laporan Lainnya',
        };
    }

    // Helper badge CSS kategori
    public function getKategoriBadgeAttribute(): string
    {
        return match ($this->kategori) {
            'penipuan_loker' => 'bg-red-50 text-red-700 border-red-200',
            'upah_tidak_sesuai' => 'bg-amber-50 text-amber-700 border-amber-200',
            'pelanggaran_sop' => 'bg-purple-50 text-purple-700 border-purple-200',
            'kontak_palsu' => 'bg-rose-50 text-rose-700 border-rose-200',
            'pekerja_mangkir' => 'bg-orange-50 text-orange-700 border-orange-200',
            default => 'bg-gray-50 text-gray-700 border-gray-200',
        };
    }
}

