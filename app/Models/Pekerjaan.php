<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'pekerjaan_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'pekerjaan_id');
    }

    public function getRatingRataRataAttribute()
    {
        if ($this->relationLoaded('ratings')) {
            $count = $this->ratings->count();
            return $count > 0 ? round($this->ratings->avg('bintang'), 1) : null;
        }
        $count = $this->ratings()->count();
        return $count > 0 ? round($this->ratings()->avg('bintang'), 1) : null;
    }

    public function getTotalRatingCountAttribute()
    {
        if ($this->relationLoaded('ratings')) {
            return $this->ratings->count();
        }
        return $this->ratings()->count();
    }
}
