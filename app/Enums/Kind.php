<?php

namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Kind: int implements HasLabel,HasColor
{
  case متغير = 0;
  case دائما_مدين = 1;
    case دائما_دائن = 2;



  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
        self::متغير => 'info',
        self::دائما_مدين => 'danger',
        self::دائما_دائن => 'success',

    };
  }

}


