<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PlantStatus: string implements HasColor, HasLabel
{
    case Active = 'active';
    case Harvested = 'harvested';
    case Dead = 'dead';
    case Transplanted = 'transplanted';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'نشط',
            self::Harvested => 'محصود',
            self::Dead => 'ميت',
            self::Transplanted => 'منقول',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Harvested => 'info',
            self::Dead => 'danger',
            self::Transplanted => 'warning',
        };
    }
}
