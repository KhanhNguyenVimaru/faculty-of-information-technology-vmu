<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\cutoff_score;
use App\Models\student;

class major extends Model
{
    /** @use HasFactory<\Database\Factories\MajorFactory> */
    use HasFactory;

    public function cutoff_scores() :HasMany
    {
        return $this->hasMany(cutoff_score::class, 'major_id');
    }
    
    public function students() :HasMany
    {
        return $this->hasMany(student::class, 'major', 'id');
    }
}
