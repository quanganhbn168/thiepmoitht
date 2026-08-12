<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Gathering extends Model implements HasMedia
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

    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GatheringGuest::class);
    }

    public function getCoverUrl(): ?string
    {
        return $this->getFirstMediaUrl('cover')
            ?: asset('images/gathering/gathering-cheers-hero.png');
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
        static::creating(function (Gathering $gathering): void {
            $gathering->status ??= 'draft';
        });

        static::saving(function (Gathering $gathering): void {
            if (filled($gathering->slug)) {
                return;
            }

            $base = Str::slug($gathering->title ?: 'hoi-ngo');
            $slug = $base ?: 'hoi-ngo';
            $suffix = 2;

            while (static::query()
                ->where('slug', $slug)
                ->when($gathering->exists, fn ($query) => $query->where('id', '!=', $gathering->id))
                ->exists()) {
                $slug = $base . '-' . $suffix++;
            }

            $gathering->slug = $slug;
        });
    }
}
