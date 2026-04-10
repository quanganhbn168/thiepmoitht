<?php

namespace App\Helpers;

use LucNham\LunarCalendar\LunarDateTime;
use Carbon\Carbon;

class LunarHelper
{
    /**
     * Can Chi cho năm (Thiên Can + Địa Chi)
     */
    protected static array $thienCan = [
        'Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý'
    ];

    protected static array $diaChi = [
        'Tý', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tỵ', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi'
    ];

    /**
     * Convert Solar date to Lunar date string (Vietnamese format)
     * 
     * @param Carbon|string|null $solarDate
     * @return string|null "DD/MM Can Chi" (e.g., "15/11 Giáp Thìn")
     */
    public static function solarToLunar($solarDate): ?string
    {
        if (empty($solarDate)) {
            return null;
        }

        try {
            $date = $solarDate instanceof Carbon ? $solarDate : Carbon::parse($solarDate);
            
            // Create LunarDateTime from solar date string using explicit conversion
            $lunar = LunarDateTime::fromGregorian($date->format('Y-m-d'));
            
            // Properties: day, month, year (converted lunar values)
            $lunarDay = $lunar->day;
            $lunarMonth = $lunar->month;
            $lunarYear = $lunar->year;
            
            // Tính Can Chi của năm
            $canIndex = ($lunarYear + 6) % 10;
            $chiIndex = ($lunarYear + 8) % 12;
            
            $canChi = self::$thienCan[$canIndex] . ' ' . self::$diaChi[$chiIndex];
            
            // Format ngày âm
            $lunarDayStr = str_pad($lunarDay, 2, '0', STR_PAD_LEFT);
            $lunarMonthStr = str_pad($lunarMonth, 2, '0', STR_PAD_LEFT);
            
            return "{$lunarDayStr}/{$lunarMonthStr} {$canChi}";
            
        } catch (\Exception $e) {
            // Log error để debug
            \Log::error('LunarHelper error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Can Chi year name only
     */
    public static function getCanChiYear(int $year): string
    {
        $canIndex = ($year + 6) % 10;
        $chiIndex = ($year + 8) % 12;
        
        return self::$thienCan[$canIndex] . ' ' . self::$diaChi[$chiIndex];
    }
}
