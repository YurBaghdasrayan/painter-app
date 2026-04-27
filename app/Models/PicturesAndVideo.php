<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PicturesAndVideo extends Model
{
    protected $table = 'pictures_and_videos';

    protected $fillable = [
        'items',
        'content',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'items' => 'array',
        'content' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}

