<?php

namespace App\Filament\Garden\Support;

use Carbon\CarbonInterface;

class GardenFormats
{
    public const TABLE_DATE = 'D, d M Y';

    public static function ageSince(?CarbonInterface $from, ?CarbonInterface $to = null): ?string
    {
        if (! $from) {
            return null;
        }

        $to ??= now();
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        if ($from->greaterThan($to)) {
            return null;
        }

        $diff = $from->diff($to);
        $parts = [];

        if ($diff->y > 0) {
            $parts[] = self::arabicCount($diff->y, 'سنة', 'سنتان', 'سنوات', 'سنة');
        }

        if ($diff->m > 0) {
            $parts[] = self::arabicCount($diff->m, 'شهر', 'شهران', 'أشهر', 'شهراً');
        }

        if ($diff->d > 0 || $parts === []) {
            $parts[] = self::arabicCount($diff->d, 'يوم', 'يومان', 'أيام', 'يوماً');
        }

        return implode(' و', $parts);
    }

    protected static function arabicCount(int $n, string $one, string $two, string $few, string $many): string
    {
        return match (true) {
            $n === 1 => $one,
            $n === 2 => $two,
            $n >= 3 && $n <= 10 => $n.' '.$few,
            default => $n.' '.$many,
        };
    }
}
