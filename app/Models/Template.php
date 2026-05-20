<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'type',
        'required_tier',
        'thumbnail_url',
        'is_active',
        'media_schema',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'media_schema' => 'array',
        'metadata' => 'array',
    ];
}
