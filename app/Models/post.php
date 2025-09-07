<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\category;
use App\Models\long_post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

class post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    public function category() :BelongsTo
    {
        return $this->belongsTo(category::class, 'category_id');
    }

    public function long_post() : HasOne
    {
        return $this->hasOne(long_post::class, 'post_id');
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
