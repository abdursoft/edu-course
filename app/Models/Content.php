<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'id',
        'title',
        'text',
        'duration',
        'content_type',
        'video',
        'embedded_link',
        'image',
        'module_id',
    ];

    /**
     * make a relation with module table
     */
    public function module(){
        return $this->belongsTo(Module::class);
    }
}
