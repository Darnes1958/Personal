<?php

namespace App\Models;

use App\Enums\Garden\InputGuideType;
use App\Enums\Garden\InputNature;
use App\Enums\Garden\InputSource;
use App\Enums\Garden\InputTimingType;
use App\Enums\Garden\PlantCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InputGuide extends Model
{
    protected function casts(): array
    {
        return [
            'type' => InputGuideType::class,
            'nature' => InputNature::class,
            'source' => InputSource::class,
            'timing_type' => InputTimingType::class,
            'components' => 'array',
            'target_categories' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(PlantInputApplication::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * @return list<string>
     */
    public function targetCategoryLabels(): array
    {
        if (blank($this->target_categories)) {
            return [];
        }

        return collect($this->target_categories)
            ->map(fn (string $value) => PlantCategory::tryFrom($value)?->getLabel() ?? $value)
            ->all();
    }
}
