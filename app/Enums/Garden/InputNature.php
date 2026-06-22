<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InputNature: string implements HasColor, HasLabel
{
    case Chemical = 'chemical';
    case Organic = 'organic';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Chemical => 'كيميائي',
            self::Organic => 'عضوي',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Chemical => 'info',
            self::Organic => 'success',
        };
    }
}
