<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CompostBinEventType: string implements HasColor, HasLabel
{
    case Filling = 'filling';
    case Turning = 'turning';
    case Watering = 'watering';
    case StageChange = 'stage_change';
    case Note = 'note';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Filling => 'إضافة / تعبئة',
            self::Turning => 'تقليب',
            self::Watering => 'رش ماء',
            self::StageChange => 'تغيير مرحلة',
            self::Note => 'ملاحظة',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Filling => 'info',
            self::Turning => 'warning',
            self::Watering => 'primary',
            self::StageChange => 'success',
            self::Note => 'gray',
        };
    }
}
