<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum GardenTaskStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Overdue = 'overdue';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'قادم',
            self::Completed => 'تم',
            self::Overdue => 'متأخر',
            self::Cancelled => 'ملغى',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'info',
            self::Completed => 'success',
            self::Overdue => 'danger',
            self::Cancelled => 'gray',
        };
    }
}
