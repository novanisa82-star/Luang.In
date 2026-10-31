<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'deadline_pendaftaran' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'pekerjaan_id');
    }

    /**
     * Memeriksa apakah lowongan sudah kadaluarsa berdasarkan batas waktu atau status.
     */
    public function getIsExpiredAttribute(): bool
    {
        if ($this->status_loker === 'ditutup') {
            return true;
        }

        if ($this->deadline_pendaftaran && now()->greaterThan($this->deadline_pendaftaran)) {
            return true;
        }

        return false;
    }

    /**
     * Memeriksa apakah lowongan masih terbuka untuk dilamar.
     */
    public function getIsOpenAttribute(): bool
    {
        return !$this->is_expired && $this->status_moderasi === 'disetujui';
    }

    /**
     * Teks sisa waktu pendaftaran yang ramah pengguna.
     */
    public function getSisaWaktuAttribute(): string
    {
        if ($this->is_expired) {
            return 'Pendaftaran Ditutup';
        }

        if (!$this->deadline_pendaftaran) {
            return 'Aktif';
        }

        $diff = now()->diff($this->deadline_pendaftaran);

        if ($diff->days > 0) {
            return "Tersisa {$diff->days} hari lagi";
        }

        if ($diff->h > 0) {
            return "Tersisa {$diff->h} jam lagi";
        }

        if ($diff->i > 0) {
            return "Tersisa {$diff->i} menit lagi";
        }

        return "Segera berakhir";
    }

    /**
     * Scope untuk mengambil hanya lowongan yang aktif dan belum kadaluarsa.
     */
    public function scopeAktifDanTerbuka($query)
    {
        return $query->where('status_moderasi', 'disetujui')
            ->where('status_loker', 'aktif')
            ->where(function ($q) {
                $q->whereNull('deadline_pendaftaran')
                  ->orWhere('deadline_pendaftaran', '>', now());
            });
    }
}
