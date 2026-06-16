<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PlantCategory: string implements HasColor, HasLabel
{
    case Tree = 'tree';
    case Vegetable = 'vegetable';
    case Ornamental = 'ornamental';
    case Aromatic = 'aromatic';
    public function getLabel(): ?string
    {
        return match ($this) {
            self::Tree => 'شجر',
            self::Vegetable => 'خضروات',
            self::Ornamental => 'زينة',
            self::Aromatic => 'عطرية',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Tree => 'success',
            self::Vegetable => 'info',
            self::Ornamental => 'warning',
            self::Aromatic => 'primary',
        };
    }
}
