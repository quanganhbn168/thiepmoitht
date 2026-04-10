<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\FallingEffect;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Reunion extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime',
        'content' => 'array',
        'is_active' => 'boolean',
        'is_auto_approve_messages' => 'boolean',
        'is_demo' => 'boolean',
        'show_preload' => 'boolean',
        'can_share' => 'boolean',
        'expires_at' => 'date',
    ];

    public function isPro(): bool
    {
        return $this->tier === 'pro';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function getMusicUrlAttribute(): ?string
    {
        if (!$this->background_music) return null;
        if (Str::startsWith($this->background_music, ['http', 'https'])) return $this->background_music;
        return asset('storage/' . $this->background_music);
    }

    // --- REUNION ASSETS HELPERS ---

    public function getMediaUrlFallback(string $collection, string $conversion = ''): string
    {
        return $this->getFirstMediaUrl($collection, $conversion);
    }

    public function getCoverUrl(): string
    {
        $url = $this->getMediaUrlFallback('share');
        return $url ?: asset('images/default-cover.jpg'); 
    }

    public function getHeroUrl(): string
    {
        $url = $this->getMediaUrlFallback('share');
        return $url ?: asset('images/hop-lop-que-vo-2.png');
    }

    public function getVideoCoverUrl(): string
    {
        $url = $this->getMediaUrlFallback('video_cover');
        return $url ?: asset('images/default-video-cover.jpg');
    }

    public function getSchoolPhotoUrl(): string
    {
        $url = $this->getMediaUrlFallback('school_photo');
        return $url ?: 'https://ui-avatars.com/api/?name=School&background=random';
    }

    public function getClassPhotoUrl(): string
    {
        $url = $this->getMediaUrlFallback('class_photo');
        return $url ?: 'https://ui-avatars.com/api/?name=Class&background=random';
    }

    public function getQrCodeUrl(): string
    {
        $url = $this->getMediaUrlFallback('qr_code');
        return $url ?: asset('images/qr-placeholder.png');
    }

    // --- RELATIONS ---

    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rsvps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReunionRsvp::class);
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReunionMessage::class);
    }

    public function approvedMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReunionMessage::class)->where('is_approved', true);
    }

    // --- SPATIE MEDIA LIBRARY ---

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('hero')->singleFile();
        $this->addMediaCollection('school_photo')->singleFile(); // Ảnh trường cũ
        $this->addMediaCollection('class_photo')->singleFile();  // Ảnh tập thể lớp
        $this->addMediaCollection('qr_code')->singleFile();      // QR Code quỹ hội
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('video')->singleFile();        // Video trailer
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('share')
            ->width(1200)
            ->height(630)
            ->sharpen(10)
            ->performOnCollections('cover')
            ->nonQueued();

        $this->addMediaConversion('optimized')
            ->width(1080)
            ->height(1920)
            ->sharpen(10)
            ->performOnCollections('hero', 'school_photo', 'class_photo')
            ->nonQueued();
            
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();
    }

    protected static function booted()
    {
        static::creating(function ($reunion) {
            $reunion->status = $reunion->status ?? 'draft';
            $reunion->tier = $reunion->tier ?? 'standard';
            $reunion->falling_effect = $reunion->falling_effect ?? 'leaves';
        });

        static::saving(function ($reunion) {
            if (empty($reunion->slug)) {
                $school = Str::slug($reunion->school_name ?? 'school');
                $class = Str::slug($reunion->class_name ?? 'class');
                $year = Str::slug($reunion->graduation_year ?? now()->year);
                
                $baseSlug = "$school-$class-$year";
                $slug = $baseSlug;
                $counter = 1;

                while (static::where('slug', $slug)->where('id', '!=', $reunion->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                
                $reunion->slug = $slug;
            }
        });
    }

    public function getContentValue($key, $default = null)
    {
        return $this->content[$key] ?? $default;
    }
}
