<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    public function pekerjaans()
    {
        return $this->hasMany(Pekerjaan::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function laporansDiterima()
    {
        return $this->hasMany(Laporan::class, 'terlapor_id');
    }

    public function laporansDiajukan()
    {
        return $this->hasMany(Laporan::class, 'pelapor_id');
    }

    /**
     * Rating yang diterima PT ini dari para pelamar.
     */
    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'pt_user_id');
    }

    /**
     * Rating yang pernah diberikan oleh user ini sebagai pelamar.
     */
    public function ratingsDiberikan()
    {
        return $this->hasMany(Rating::class, 'reviewer_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_suspended' => 'boolean',
        ];
    }
}
