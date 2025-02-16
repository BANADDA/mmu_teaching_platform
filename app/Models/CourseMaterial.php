<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseMaterial extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'lecture_id',
        'user_id' // uploader id
    ];

    /**
     * Get the lecture that owns the material.
     */
    public function lecture(): BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }

    /**
     * Get the user that uploaded the material.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
