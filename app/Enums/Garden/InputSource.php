<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InputSource: string implements HasColor, HasLabel
{
    case Pharmacy = 'pharmacy';
    case AgriculturalPharmacy = 'agricultural_pharmacy';
    case Homemade = 'homemade';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pharmacy => 'صيدلية',
            self::AgriculturalPharmacy => 'صيدلية زراعية',
            self::Homemade => 'مصنوع في المنزل',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pharmacy => 'primary',
            self::AgriculturalPharmacy => 'success',
            self::Homemade => 'warning',
        };
    }
}
