<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecture extends Model
{
    protected $fillable = [
        'name',
        'description',
        'department_id',
        'user_id' // lecturer id
    ];

    /**
     * Get the department that owns the lecture.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the lecturer that owns the lecture.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the materials for the lecture.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(CourseMaterial::class);
    }
}
