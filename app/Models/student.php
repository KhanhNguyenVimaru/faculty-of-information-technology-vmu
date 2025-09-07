<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\major;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    
    public function major(): BelongsTo
    {
        return $this->belongsTo(major::class, 'major', 'id');
    }
}
