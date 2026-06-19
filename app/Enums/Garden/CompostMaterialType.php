<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CompostMaterialType: string implements HasColor, HasLabel
{
    case AnimalManure = 'animal_manure';
    case Compost = 'compost';
    case LeafMold = 'leaf_mold';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AnimalManure => 'سماد حيواني طبيعي',
            self::Compost => 'كمبوست',
            self::LeafMold => 'بتموس (أوراق جافة)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AnimalManure => 'warning',
            self::Compost => 'success',
            self::LeafMold => 'info',
        };
    }
}
