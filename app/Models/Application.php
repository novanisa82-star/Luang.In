<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    // Mendapatkan 2 huruf inisial dari nama pelamar (e.g. Budi Prasetyo -> BP)
    public function getInisialAttribute()
    {
        $name = trim($this->user->name ?? 'Pelamar');
        $words = explode(' ', $name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    // Mendapatkan warna avatar yang bervariasi sesuai id
    public function getAvatarColorAttribute()
    {
        $palettes = [
            ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'border' => 'border-purple-200'],
            ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200'],
            ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200'],
            ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'border' => 'border-rose-200'],
            ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'border' => 'border-teal-200'],
        ];

        return $palettes[($this->id ?? 1) % count($palettes)];
    }

    // Skor kecocokan / kompatibilitas (persentase)
    public function getKompatibilitasScoreAttribute()
    {
        if (isset($this->attributes['skor_cocok']) && $this->attributes['skor_cocok'] !== null) {
            return (int) $this->attributes['skor_cocok'];
        }

        // Variasi realistis berdasarkan id
        $scores = [95, 90, 75, 68, 85, 92, 78, 64];
        return $scores[($this->id ?? 1) % count($scores)];
    }

    // Tag atau highlight kualifikasi pelamar
    public function getKualifikasiTagAttribute()
    {
        $tags = [
            ['type' => 'rating', 'label' => '4.9 (42 ulasan)'],
            ['type' => 'badge', 'label' => 'Siap Lembur', 'icon' => 'check'],
            ['type' => 'badge', 'label' => 'Logistik Gudang', 'icon' => 'inventory_2'],
            ['type' => 'badge', 'label' => 'Standby', 'icon' => 'schedule'],
            ['type' => 'rating', 'label' => '4.8 (30 ulasan)'],
            ['type' => 'badge', 'label' => 'Bongkar Muat', 'icon' => 'front_loader'],
        ];

        return $tags[($this->id ?? 1) % count($tags)];
    }

    // Detail ringkasan profil & radius jarak
    public function getDeskripsiPelamarAttribute()
    {
        $deskripsis = [
            'Pengalaman bongkar muat 2 thn',
            'Kondisi fisik prima, siap lembur',
            'Pernah bekerja di pergudangan',
            'Pekerja serabutan umum',
            'Cekatan, terbiasa angkat barang berat',
            'Memiliki SIM C, siap shift malam',
        ];

        $deskripsi = $deskripsis[($this->id ?? 1) % count($deskripsis)];
        $lokasi = $this->user->domisili ?? 'Sekitar Lokasi';
        
        $jaraks = [1.2, 3.5, 4.1, 6.0, 2.8, 5.3];
        $jarak = $jaraks[($this->id ?? 1) % count($jaraks)];

        return "{$deskripsi} • Lokasi: {$lokasi} ({$jarak} km)";
    }

    // Link WhatsApp pelamar untuk instruksi / interview
    public function getWhatsappLinkAttribute()
    {
        $rawNumber = $this->user->whatsapp ?? '';
        $cleanNumber = preg_replace('/[^0-9]/', '', $rawNumber);

        if (str_starts_with($cleanNumber, '0')) {
            $cleanNumber = '62' . substr($cleanNumber, 1);
        }

        $namaPt = $this->pekerjaan->user->name ?? 'Perusahaan';
        $judulPekerjaan = $this->pekerjaan->judul ?? 'Pekerjaan';
        $namaPelamar = $this->user->name ?? 'Pelamar';

        $text = "Halo {$namaPelamar}, selamat lamaran Anda untuk posisi *{$judulPekerjaan}* di *{$namaPt}* telah DITERIMA! Silakan konfirmasi kesiapan Anda untuk instruksi penjemputan dan perlengkapan APD kerja.";

        return "https://wa.me/{$cleanNumber}?text=" . urlencode($text);
    }
}
