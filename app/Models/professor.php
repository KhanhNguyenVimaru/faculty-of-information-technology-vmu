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
}
