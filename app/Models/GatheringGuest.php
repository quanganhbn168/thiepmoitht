<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GatheringGuest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function gathering(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Gathering::class);
    }

    protected static function booted(): void
    {
        static::saving(function (GatheringGuest $guest): void {
            if (filled($guest->code)) {
                return;
            }

            $base = Str::slug($guest->name ?: 'khach-moi');
            $code = $base ?: 'khach-moi';
            $suffix = 2;

            while (static::query()
                ->where('gathering_id', $guest->gathering_id)
                ->where('code', $code)
                ->when($guest->exists, fn ($query) => $query->where('id', '!=', $guest->id))
                ->exists()) {
                $code = $base . '-' . $suffix++;
            }

            $guest->code = $code;
        });
    }
}
