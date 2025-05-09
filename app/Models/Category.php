<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'poster',
        'preview',
    ];

    /**
     * make a relation with course model
     */
    public function course()
    {
        return $this->hasMany(Course::class);
    }
}
