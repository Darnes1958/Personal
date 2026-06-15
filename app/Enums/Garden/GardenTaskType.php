<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasLabel;

enum GardenTaskType: string implements HasLabel
{
    case Planting = 'planting';
    case Fertilizing = 'fertilizing';
    case Watering = 'watering';
    case Harvest = 'harvest';
    case Pruning = 'pruning';
    case CompostTurn = 'compost_turn';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Planting => 'زراعة',
            self::Fertilizing => 'تسميد',
            self::Watering => 'ري',
            self::Harvest => 'حصاد',
            self::Pruning => 'تقليم',
            self::CompostTurn => 'تقليب كومبوست',
            self::Other => 'أخرى',
        };
    }
}
