<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $guarded = [];

    /**
     * Pelamar yang memberikan rating ini.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Admin PT yang menerima rating ini.
     */
    public function ptUser()
    {
        return $this->belongsTo(User::class, 'pt_user_id');
    }

    /**
     * Lamaran yang terkait dengan rating ini.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Lowongan/pekerjaan yang terkait.
     */
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }
}
