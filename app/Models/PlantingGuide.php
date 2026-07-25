<?php

namespace App\Models;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\Season;
use App\Models\Concerns\HasMonthDayRange;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class PlantingGuide extends Model
{
    use HasMonthDayRange;

    protected function casts(): array
    {
        return [
            'category' => PlantCategory::class,
            'season' => Season::class,
            'is_active' => 'boolean',
        ];
    }

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }

    public function spacings(): HasMany
    {
        return $this->hasMany(PlantSpacing::class);
    }

    public function isPlantableOn(string $monthDay): bool
    {
        return $this->isDateInRange($monthDay, $this->planting_start, $this->planting_end);
    }

    public function isHarvestableOn(string $monthDay): bool
    {
        return $this->isDateInRange($monthDay, $this->harvest_start, $this->harvest_end);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function plantableOnDate(?string $monthDay = null): Collection
    {
        $monthDay ??= now()->format('m-d');

        return static::active()
            ->orderBy('name')
            ->get()
            ->filter(fn (PlantingGuide $guide) => $guide->isPlantableOn($monthDay));
    }

    public static function plantableInMonth(int $month): Collection
    {
        return static::active()
            ->plantableInMonth($month)
            ->orderBy('name')
            ->get();
    }

    public function scopePlantableInMonth(Builder $query, int $month): Builder
    {
        $driver = $query->getConnection()->getDriverName();

        $startMonthExpr = match ($driver) {
            'sqlsrv' => 'CAST(LEFT(planting_start, 2) AS INT)',
            default => 'CAST(SUBSTR(planting_start, 1, 2) AS INTEGER)',
        };

        $endMonthExpr = match ($driver) {
            'sqlsrv' => 'CAST(LEFT(planting_end, 2) AS INT)',
            default => 'CAST(SUBSTR(planting_end, 2) AS INTEGER)',
        };

        return $query->where(function (Builder $query) use ($month, $startMonthExpr, $endMonthExpr) {
            $query->where(function (Builder $query) use ($month, $startMonthExpr, $endMonthExpr) {
                $query->whereRaw("{$startMonthExpr} <= {$endMonthExpr}")
                    ->whereRaw("? BETWEEN {$startMonthExpr} AND {$endMonthExpr}", [$month]);
            })->orWhere(function (Builder $query) use ($month, $startMonthExpr, $endMonthExpr) {
                $query->whereRaw("{$startMonthExpr} > {$endMonthExpr}")
                    ->where(function (Builder $query) use ($month, $startMonthExpr, $endMonthExpr) {
                        $query->whereRaw("? >= {$startMonthExpr}", [$month])
                            ->orWhereRaw("? <= {$endMonthExpr}", [$month]);
                    });
            });
        });
    }

    /** @return array<int, string> */
    public static function monthOptions(): array
    {
        return [
            1 => '1 — يناير',
            2 => '2 — فبراير',
            3 => '3 — مارس',
            4 => '4 — أبريل',
            5 => '5 — مايو',
            6 => '6 — يونيو',
            7 => '7 — يوليو',
            8 => '8 — أغسطس',
            9 => '9 — سبتمبر',
            10 => '10 — أكتوبر',
            11 => '11 — نوفمبر',
            12 => '12 — ديسمبر',
        ];
    }

    public function monthOverlapsRange(int $month, string $start, string $end): bool
    {
        $startMonth = (int) explode('-', $start)[0];
        $endMonth = (int) explode('-', $end)[0];

        if ($startMonth <= $endMonth) {
            return $month >= $startMonth && $month <= $endMonth;
        }

        return $month >= $startMonth || $month <= $endMonth;
    }
}
