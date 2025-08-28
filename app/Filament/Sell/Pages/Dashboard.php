<?php

namespace App\Filament\Sell\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.sell.pages.dashboard';
    protected ?string $heading='';
    protected static bool $shouldRegisterNavigation=false;
    public function getColumns(): int | string | array
    {
        return 4;
    }
}
