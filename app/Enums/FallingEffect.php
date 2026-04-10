<?php

namespace App\Enums;

enum FallingEffect: string
{
    case HEARTS = 'hearts';
    case PETALS = 'petals';
    case SNOW = 'snow';
    case LEAVES = 'leaves';
    case STARS = 'stars';
    case SHOOTING_STARS = 'shooting_stars';
    case NONE = 'none';
    
    public function label(): string
    {
        return match($this) {
            self::HEARTS => '💕 Trái tim',
            self::PETALS => '🌸 Cánh hoa',
            self::SNOW => '❄️ Tuyết',
            self::LEAVES => '🍂 Lá rơi',
            self::STARS => '⭐ Ngôi sao',
            self::SHOOTING_STARS => '🌠 Sao băng (Pro)',
            self::NONE => '🚫 Không hiệu ứng',
        };
    }
    
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }
}
