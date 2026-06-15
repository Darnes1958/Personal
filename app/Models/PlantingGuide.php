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
            ->orderBy('name')
            ->get()
            ->filter(fn (PlantingGuide $guide) => $guide->monthOverlapsRange(
                $month,
                $guide->planting_start,
                $guide->planting_end,
            ));
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
