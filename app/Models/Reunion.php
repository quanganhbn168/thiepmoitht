<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    // ==========================================
    // STATUS HELPERS
    // ==========================================

    public function isPro(): bool
    {
        return $this->tier === 'pro';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    // ==========================================
    // MEDIA URL HELPERS
    // ==========================================

    public function getMediaUrlByCollection(string $collection, ?string $fallback = null, string $conversion = ''): ?string
    {
        $url = $this->getFirstMediaUrl($collection, $conversion);

        return $url ?: $fallback;
    }

    public function getLogoUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'logo',
            asset('images/default-logo.png')
        );
    }

    public function getShareUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'share',
            asset('images/default-cover.jpg')
        );
    }

    public function getCoverUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'cover',
            $this->getShareUrl()
        );
    }

    public function getHeroUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'hero_background',
            $this->getMediaUrlByCollection(
                'hero',
                $this->getShareUrl() ?: asset('images/hop-lop-que-vo-2.png')
            )
        );
    }

    public function getHeroPhoto1Url(): string
    {
        return $this->getMediaUrlByCollection(
            'hero_photo_1',
            $this->getHeroUrl()
        );
    }

    public function getHeroPhoto2Url(): string
    {
        return $this->getMediaUrlByCollection(
            'hero_photo_2',
            $this->getCoverUrl()
        );
    }

    public function getHeroPhoto3Url(): string
    {
        return $this->getMediaUrlByCollection(
            'hero_photo_3',
            $this->getHeroUrl()
        );
    }

    public function getVideoCoverUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'video_cover',
            asset('images/default-video-cover.jpg')
        );
    }

    public function getVideoUrl(): ?string
    {
        return $this->getMediaUrlByCollection('video');
    }

    public function getSchoolPhotoUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'school_photo',
            'https://ui-avatars.com/api/?name=School&background=random'
        );
    }

    public function getClassPhotoUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'class_photo',
            'https://ui-avatars.com/api/?name=Class&background=random'
        );
    }

    public function getQrCodeUrl(): string
    {
        return $this->getMediaUrlByCollection(
            'qr_code',
            asset('images/qr-placeholder.png')
        );
    }

    public function getMusicUrlAttribute(): ?string
    {
        if (!$this->background_music) {
            return null;
        }

        if (Str::startsWith($this->background_music, ['http://', 'https://'])) {
            return $this->background_music;
        }

        return asset('storage/' . $this->background_music);
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

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
        return $this->hasMany(ReunionMessage::class)
            ->where('is_approved', true);
    }

    // ==========================================
    // SPATIE MEDIA LIBRARY
    // ==========================================

    public function registerMediaCollections(): void
    {
        $singleFileCollections = [
            'logo',
            'share',
            'cover',
            'hero',
            'hero_background',
            'hero_image_01',
            'hero_photo_1',
            'hero_photo_2',
            'hero_photo_3',
            'video_cover',
            'video',
            'school_photo',
            'class_photo',
            'qr_code',
        ];

        foreach ($singleFileCollections as $collection) {
            $this
                ->addMediaCollection($collection)
                ->useDisk('public')
                ->singleFile();
        }

        $this
            ->addMediaCollection('gallery')
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('share')
            ->width(1200)
            ->height(630)
            ->sharpen(10)
            ->performOnCollections('share', 'cover');

        $this
            ->addMediaConversion('optimized')
            ->width(1080)
            ->height(1920)
            ->sharpen(10)
            ->performOnCollections(
                'hero',
                'hero_background',
                'hero_image_01',
                'hero_photo_1',
                'hero_photo_2',
                'hero_photo_3',
                'video_cover',
                'school_photo',
                'class_photo'
            );

        $this
            ->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->performOnCollections(
                'logo',
                'share',
                'cover',
                'hero',
                'hero_background',
                'hero_image_01',
                'hero_photo_1',
                'hero_photo_2',
                'hero_photo_3',
                'video_cover',
                'school_photo',
                'class_photo',
                'qr_code',
                'gallery'
            );
    }

    // ==========================================
    // CONTENT HELPERS
    // ==========================================

    public function getContentValue(string $key, mixed $default = null): mixed
    {
        return data_get($this->content, $key, $default);
    }

    // ==========================================
    // MODEL EVENTS
    // ==========================================

    protected static function booted(): void
    {
        static::creating(function (Reunion $reunion): void {
            $reunion->status = $reunion->status ?? 'draft';
            $reunion->tier = $reunion->tier ?? 'standard';
            $reunion->falling_effect = $reunion->falling_effect ?? 'leaves';
        });

        static::saving(function (Reunion $reunion): void {
            if (!empty($reunion->slug)) {
                return;
            }

            $school = Str::slug($reunion->school_name ?: 'school');
            $class = Str::slug($reunion->class_name ?: 'class');
            $year = Str::slug($reunion->graduation_year ?: now()->year);

            $baseSlug = "{$school}-{$class}-{$year}";
            $slug = $baseSlug;
            $counter = 1;

            while (
                static::query()
                    ->where('slug', $slug)
                    ->where('id', '!=', $reunion->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $reunion->slug = $slug;
        });
    }
}
