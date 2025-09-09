<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\professor;
use App\Models\User;

class department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;
    public $timestamps = false;

    public function headProfessor() :BelongsTo
    {
        return $this->belongsTo(professor::class, 'head_of_department_id', 'professor_id');
    }
    public function professors() :HasMany
    {
        return $this->hasMany(professor::class, 'department_id');
    }

    public function scopeSearch($query, $search)
    {
        $term = "%$search%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                  ->orWhere('code', 'like', $term);
        });
    }
    
    /**
     * Lấy thông tin User của trưởng bộ môn
     */
    public function headUser() :HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            professor::class,
            'professor_id', // Khóa ngoại trên bảng professor liên kết với department
            'id', // Khóa chính trên bảng users
            'head_of_department_id', // Khóa ngoại trên bảng department liên kết với professor
            'professor_id' // Khóa trên bảng professor liên kết với users
        );
    }
    
    /**
     * Lấy danh sách User của tất cả giảng viên trong bộ môn
     */
    public function users() :HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            professor::class,
            'department_id', // Khóa ngoại trên bảng professor liên kết với department
            'id', // Khóa chính trên bảng users
            'id', // Khóa chính trên bảng department
            'professor_id' // Khóa trên bảng professor liên kết với users
        );
    }
}
