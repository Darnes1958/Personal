<?php

namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum hisSystem: string implements HasLabel,HasColor
{
  case Personal = 'personal';
  case Sell = 'sell';
  case Acc = 'acc';
    case Card = 'card';
  case Garden = 'garden';



  public function getLabel(): ?string
  {
      return match ($this) {
          self::Garden => 'حديقتي',
          default => str_replace('_', ' ', $this->name),
      };
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
        self::Sell => 'info',
        self::Personal => 'danger',
        self::Acc => 'primary',
        self::Card => 'success',
        self::Garden => 'success',
    };
  }

}


