<?php

namespace App\Enums\Garden;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CompostBinStage: string implements HasColor, HasLabel
{
    case Empty = 'empty';
    case Filling = 'filling';
    case Turning = 'turning';
    case Fermenting = 'fermenting';
    case Ready = 'ready';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Empty => 'فارغ',
            self::Filling => 'تعبئة / توريد',
            self::Turning => 'تقليب ورش ماء',
            self::Fermenting => 'تخمير',
            self::Ready => 'جاهز للاستعمال',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Empty => 'الحوض فارغ ولا يحتوي مواد.',
            self::Filling => 'مرحلة إضافة المواد — عادة أيام إلى أسابيع.',
            self::Turning => 'تقليب ورش ماء — عادة من شهرين إلى أربعة أشهر.',
            self::Fermenting => 'تخمير — عادة أسبوع إلى ثلاثة أسابيع.',
            self::Ready => 'السماد جاهز للاستعمال في الحديقة.',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Empty => 'gray',
            self::Filling => 'info',
            self::Turning => 'warning',
            self::Fermenting => 'primary',
            self::Ready => 'success',
        };
    }
}
