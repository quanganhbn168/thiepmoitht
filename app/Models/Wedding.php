<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Wedding extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime',
        'content' => 'array',
        'is_active' => 'boolean',
        'can_share' => 'boolean',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function getCoverUrl(): ?string
    {
        return $this->getFirstMediaUrl('cover') ?: null;
    }

    public function getShareUrl(): ?string
    {
        return $this->getFirstMediaUrl('share') ?: $this->getCoverUrl();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->useDisk('public')->singleFile();
        $this->addMediaCollection('share')->useDisk('public')->singleFile();
        $this->addMediaCollection('payment_qr')->useDisk('public')->singleFile();
        $this->addMediaCollection('gallery')->useDisk('public');
    }

    protected static function booted(): void
    {
        static::creating(function (Wedding $wedding): void {
            $wedding->status ??= 'draft';
        });

        static::saving(function (Wedding $wedding): void {
            if (filled($wedding->slug)) {
                return;
            }

            $base = Str::slug('dam-cuoi-'.$wedding->groom_name.'-'.$wedding->bride_name);
            $base = $base ?: 'dam-cuoi';
            $slug = $base;
            $suffix = 2;

            while (static::query()
                ->where('slug', $slug)
                ->when($wedding->exists, fn ($query) => $query->whereKeyNot($wedding->getKey()))
                ->exists()) {
                $slug = $base.'-'.$suffix++;
            }

            $wedding->slug = $slug;
        });
    }
}
