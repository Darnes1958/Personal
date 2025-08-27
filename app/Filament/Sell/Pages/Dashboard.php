<?php

namespace App\Filament\Sell\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.sell.pages.dashboard';
    protected ?string $heading='';
    public function getColumns(): int | string | array
    {
        return 4;
    }
}
