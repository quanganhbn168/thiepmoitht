<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReunionMessage extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function reunion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Reunion::class);
    }
}
