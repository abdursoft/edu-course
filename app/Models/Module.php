<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'id',
        'title',
        'duration',
        'live_class',
        'assignment',
        'support_class',
        'recorded_class',
        'course_id',
    ];

    /**
     * make a relation with course table
     */
    public function course(){
        return $this->belongsTo(Course::class);
    }

    /**
     * make a relation with content table
     */
    public function contents(){
        return $this->hasMany(Content::class);
    }
}
