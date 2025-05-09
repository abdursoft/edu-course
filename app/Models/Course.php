<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'id',
        'title',
        'description',
        'preview',
        'price',
        'course_type',
        'duration',
        'category_id',
        'user_id',
        'preview_image'
    ];

    /**
     * make a relation with category table
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * make a relation with module table
     */
    public function modules(){
        return $this->hasMany(Module::class);
    }
}
