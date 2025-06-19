<?php

namespace App\Enums;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AccKind: int implements HasLabel,HasColor
{
  case نقدا = 0;
  case مصرفي = 1;
  case خدمة_إلكترونية = 2;



  public function getLabel(): ?string
  {
      return str_replace('_', ' ',  $this->name);
  }
  public function getColor(): string | array | null
  {
    return match ($this) {
        self::مصرفي => 'info',
        self::خدمة_إلكترونية => 'primary',
        self::نقدا => 'success',

    };
  }

}


