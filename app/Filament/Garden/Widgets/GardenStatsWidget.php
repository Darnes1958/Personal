<?php

namespace App\Filament\Garden\Widgets;

use App\Enums\Garden\GardenTaskStatus;
use App\Enums\Garden\PlantStatus;
use App\Models\GardenTask;
use App\Models\Plant;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GardenStatsWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'ملخص الحديقة';

    protected function getStats(): array
    {
        GardenTask::refreshOverdue();

        $todayTasks = GardenTask::query()
            ->whereDate('due_date', now()->toDateString())
            ->whereIn('status', [GardenTaskStatus::Pending, GardenTaskStatus::Overdue])
            ->count();

        $overdueTasks = GardenTask::query()
            ->where('status', GardenTaskStatus::Overdue)
            ->count();

        $activePlants = Plant::query()
            ->where('status', PlantStatus::Active)
            ->count();

        return [
            Stat::make('مهام اليوم', $todayTasks)
                ->description('مواعيد اليوم')
                ->color($todayTasks > 0 ? 'warning' : 'success'),
            Stat::make('مهام متأخرة', $overdueTasks)
                ->description('تحتاج متابعة')
                ->color($overdueTasks > 0 ? 'danger' : 'success'),
            Stat::make('نباتات نشطة', $activePlants)
                ->description('قيد المتابعة')
                ->color('primary'),
        ];
    }
}
