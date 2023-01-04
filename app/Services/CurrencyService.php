<?php

namespace App\Services;

class CurrencyService
{
    const RATE = [
        'usd' => [
            'euro' => 0.98,
            'ngn' => 388
        ]
    ];

    public function convert($amount, string $from, string $to): float
    {
        $rate = self::RATE[$from][$to] ?? 0;

        return round($amount * $rate, 2);
    }
}
