<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\department;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class professor extends Model
{
    /** @use HasFactory<\Database\Factories\ProfessorFactory> */
    use HasFactory;

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deparment(): HasOne
    {
        return $this->hasOne(department::class, 'user_id');
    }
}
