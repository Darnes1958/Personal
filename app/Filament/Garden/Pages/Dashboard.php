<?php

namespace App\Filament\Garden\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationLabel = 'لوحة التحكم';

    protected ?string $heading = 'حديقتي — لوحة التحكم';

    public function getColumns(): int|array
    {
        return 2;
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Garden\Widgets\GardenStatsWidget::class,
            \App\Filament\Garden\Widgets\TodayTasksWidget::class,
        ];
    }
}
