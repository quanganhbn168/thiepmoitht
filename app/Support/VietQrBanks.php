<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class VietQrBanks
{
    private const FALLBACK_OPTIONS = [
        '970436' => 'Vietcombank',
        '970415' => 'VietinBank',
        '970418' => 'BIDV',
        '970422' => 'MB Bank',
        '970407' => 'Techcombank',
        '970432' => 'VPBank',
        '970423' => 'TPBank',
        '970416' => 'ACB',
        '970405' => 'Agribank',
        '970403' => 'Sacombank',
        '970441' => 'VIB',
        '970448' => 'OCB',
        '970443' => 'SHB',
        '970431' => 'Eximbank',
    ];

    public static function options(): array
    {
        return Cache::remember('vietqr.bank-options', now()->addDay(), static function (): array {
            try {
                $banks = Http::acceptJson()
                    ->timeout(3)
                    ->get('https://api.vietqr.io/v2/banks')
                    ->json('data');

                if (is_array($banks)) {
                    $options = collect($banks)
                        ->filter(fn (array $bank): bool => filled($bank['bin'] ?? null) && (int) ($bank['transferSupported'] ?? 0) === 1)
                        ->mapWithKeys(fn (array $bank): array => [
                            (string) $bank['bin'] => trim(($bank['shortName'] ?? $bank['code'] ?? 'Ngân hàng').' — '.($bank['name'] ?? '')),
                        ])
                        ->sort()
                        ->all();

                    if ($options !== []) {
                        return $options;
                    }
                }
            } catch (Throwable) {
                // The compact fallback keeps the QR form available offline.
            }

            return self::FALLBACK_OPTIONS;
        });
    }
}
