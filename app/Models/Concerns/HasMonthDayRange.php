<?php

namespace App\Models\Concerns;

trait HasMonthDayRange
{
    public function isDateInRange(string $monthDay, ?string $start, ?string $end): bool
    {
        if (blank($start) || blank($end)) {
            return false;
        }

        if ($start <= $end) {
            return $monthDay >= $start && $monthDay <= $end;
        }

        return $monthDay >= $start || $monthDay <= $end;
    }

    public function formatMonthDayRange(?string $start, ?string $end): ?string
    {
        if (blank($start) || blank($end)) {
            return null;
        }

        return $this->formatMonthDay($start).' — '.$this->formatMonthDay($end);
    }

    protected function formatMonthDay(string $monthDay): string
    {
        [$month, $day] = explode('-', $monthDay);

        return (int) $day.'/'.(int) $month;
    }
}
