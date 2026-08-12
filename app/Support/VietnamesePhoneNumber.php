<?php

namespace App\Support;

final class VietnamesePhoneNumber
{
    public static function normalize(mixed $value): string
    {
        $phone = preg_replace('/\D+/', '', trim((string) $value)) ?? '';

        if (str_starts_with($phone, '0084')) {
            $phone = '0'.substr($phone, 4);
        } elseif (str_starts_with($phone, '84') && strlen($phone) === 11) {
            $phone = '0'.substr($phone, 2);
        }

        return $phone;
    }

    public static function isValid(mixed $value): bool
    {
        return preg_match('/^0(?:3|5|7|8|9)\d{8}$/', self::normalize($value)) === 1;
    }
}
