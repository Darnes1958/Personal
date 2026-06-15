<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasLabel;

enum Season: string implements HasLabel
{
    case Spring = 'spring';
    case Summer = 'summer';
    case Autumn = 'autumn';
    case Winter = 'winter';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Spring => 'ربيع',
            self::Summer => 'صيف',
            self::Autumn => 'خريف',
            self::Winter => 'شتاء',
        };
    }

    public static function fromMonth(int $month): self
    {
        return match (true) {
            in_array($month, [3, 4, 5]) => self::Spring,
            in_array($month, [6, 7, 8]) => self::Summer,
            in_array($month, [9, 10, 11]) => self::Autumn,
            default => self::Winter,
        };
    }
}
