<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InputTimingType: string implements HasColor, HasLabel
{
    case PlantAge = 'plant_age';
    case GrowthStage = 'growth_stage';
    case Phenomenon = 'phenomenon';
    case Preventive = 'preventive';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PlantAge => 'فترة عمر النبات',
            self::GrowthStage => 'مرحلة نمو',
            self::Phenomenon => 'مجابهة ظاهرة / مرض',
            self::Preventive => 'وقائي',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PlantAge => 'info',
            self::GrowthStage => 'success',
            self::Phenomenon => 'danger',
            self::Preventive => 'warning',
        };
    }
}
