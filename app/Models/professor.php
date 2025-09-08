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
    protected $table = 'professors';
    protected $primaryKey = 'professor_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Tắt timestamps vì bảng không có trường created_at và updated_at
    protected $fillable = [
        'professor_id',
        'name',
        'email',
        'position',
        'department_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professor_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(department::class, 'department_id');
    }

    public function headOfDepartment()
    {
        return $this->hasOne(department::class, 'head_of_department_id', 'professor_id');
    }

    // scope search
    // querry builder
    public function scopeWhereSearch($query, $search)
    {
        return $query
            ->where(function ($q) use ($search) {
                $q->where('professor_id', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
    }
    public function scopeWhereEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }
    public function scopeWhereId($query, $id)
    {
        return $query->where('id', 'like', "%{$id}%");
    }
    public function scopeWherePosition($query, $position)
    {
        return $query->where('position', 'like', "%{$position}%");
    }
}
