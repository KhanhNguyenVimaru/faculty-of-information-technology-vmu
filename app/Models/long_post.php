<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class long_post extends Model
{
    /** @use HasFactory<\Database\Factories\LongPostFactory> */
    use HasFactory;

    public function post() :BelongsTo
    {
        return $this->belongsTo(post::class, 'id');
    }
}
