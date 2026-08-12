<?php

namespace App\Support;

class VietQrQuickLink
{
    public static function imageUrl(
        ?string $bankBin,
        ?string $accountNumber,
        ?int $amount = null,
        ?string $transferNote = null,
        ?string $accountName = null,
    ): ?string {
        $bankBin = trim((string) $bankBin);
        $accountNumber = preg_replace('/\s+/', '', trim((string) $accountNumber));

        if ($bankBin === '' || $accountNumber === '') {
            return null;
        }

        $parameters = array_filter([
            'amount' => $amount && $amount > 0 ? $amount : null,
            'addInfo' => self::limit($transferNote, 25),
            'accountName' => self::limit($accountName, 50),
        ], static fn ($value): bool => $value !== null && $value !== '');

        $url = sprintf(
            'https://img.vietqr.io/image/%s-%s-compact2.png',
            rawurlencode($bankBin),
            rawurlencode($accountNumber),
        );

        return $parameters === []
            ? $url
            : $url.'?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
    }

    private static function limit(?string $value, int $length): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : mb_substr($value, 0, $length);
    }
}
