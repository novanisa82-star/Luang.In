<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillProfile extends Model
{
    protected $fillable = [
        'user_id',
        'whatsapp',
        'domisili',
        'primary_role',
        'skills',
        'experience',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}