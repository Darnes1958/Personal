<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InputGuideType: string implements HasColor, HasLabel
{
    case Nutrient = 'nutrient';
    case Pesticide = 'pesticide';
    case Combined = 'combined';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Nutrient => 'عنصر غذائي / سماد',
            self::Pesticide => 'مبيد / مكافحة أمراض',
            self::Combined => 'مزيج (عناصر مجتمعة)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Nutrient => 'success',
            self::Pesticide => 'danger',
            self::Combined => 'warning',
        };
    }
}
