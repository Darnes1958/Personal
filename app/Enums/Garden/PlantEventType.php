<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PlantEventType: string implements HasColor, HasLabel
{
    case Planting = 'planting';
    case Fertilizing = 'fertilizing';
    case Watering = 'watering';
    case Growth = 'growth';
    case Flowering = 'flowering';
    case Fruiting = 'fruiting';
    case Harvest = 'harvest';
    case Pruning = 'pruning';
    case Disease = 'disease';
    case Note = 'note';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Planting => 'زراعة',
            self::Fertilizing => 'تسميد',
            self::Watering => 'ري',
            self::Growth => 'نمو',
            self::Flowering => 'إزهار',
            self::Fruiting => 'ثمار',
            self::Harvest => 'حصاد',
            self::Pruning => 'تقليم',
            self::Disease => 'مرض / آفة',
            self::Note => 'ملاحظة',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Planting => 'success',
            self::Fertilizing => 'info',
            self::Watering => 'primary',
            self::Growth => 'success',
            self::Flowering => 'warning',
            self::Fruiting => 'info',
            self::Harvest => 'success',
            self::Pruning => 'gray',
            self::Disease => 'danger',
            self::Note => 'gray',
        };
    }
}
