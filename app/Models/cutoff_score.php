<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\major;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class cutoff_score extends Model
{
    /** @use HasFactory<\Database\Factories\CutoffScoreFactory> */
    use HasFactory;

    public function major(): BelongsTo {
        return $this->belongsTo(major::class, 'major_id');
    }
}
