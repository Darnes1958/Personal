<?php

namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum hisSystem: string implements HasLabel,HasColor
{
  case Personal = 'personal';
  case Sell = 'sell';




  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
        self::Sell => 'info',
        self::Personal => 'danger',
    };
  }

}


