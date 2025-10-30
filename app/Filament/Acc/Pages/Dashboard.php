<?php

namespace App\Filament\Acc\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected ?string $heading="منظومة المحاسبة - الصفحة الرئيسية";
    public function getColumns(): int|array
    {
        return 6;
    }
}
