<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'school_id'
    ];

    /**
     * Get the school that owns the department.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the users (lecturers) for the department.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'department_user')
                    ->withTimestamps();
    }

    /**
     * Get the lectures for the department.
     */
    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    /**
     * Get the lecturer count for the department
     */
    public function getLecturersCountAttribute(): int
    {
        return $this->users()->where('role_id', 2)->count();
    }
}
