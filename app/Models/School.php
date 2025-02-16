<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description'
    ];

    /**
     * Get the departments for the school.
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the total number of departments in the school
     */
    public function getDepartmentsCountAttribute(): int
    {
        return $this->departments()->count();
    }

    /**
     * Get the total number of lecturers in the school
     */
    public function getLecturersCountAttribute(): int
    {
        return $this->departments()
            ->join('department_user', 'departments.id', '=', 'department_user.department_id')
            ->join('users', 'department_user.user_id', '=', 'users.id')
            ->where('users.role_id', 2) // Assuming 2 is lecturer role_id
            ->distinct()
            ->count('users.id');
    }
}
