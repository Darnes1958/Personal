<?php

namespace App\Filament\Garden\Widgets;

use App\Enums\Garden\GardenTaskStatus;
use App\Filament\Garden\Resources\GardenTasks\GardenTaskResource;
use App\Models\GardenTask;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class TodayTasksWidget extends TableWidget
{
    protected static ?string $heading = 'مهام اليوم';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        GardenTask::refreshOverdue();

        return $table
            ->query(
                GardenTask::query()
                    ->whereDate('due_date', now()->toDateString())
                    ->whereIn('status', [GardenTaskStatus::Pending, GardenTaskStatus::Overdue])
                    ->orderBy('due_date')
            )
            ->columns([
                TextColumn::make('title')
                    ->label('المهمة'),
                TextColumn::make('plant.name')
                    ->label('النبات')
                    ->placeholder('—'),
                TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),
            ])
            ->recordActions([
                Action::make('complete')
                    ->label('تم')
                    ->icon('heroicon-o-check')
                    ->action(fn (GardenTask $record) => $record->markCompleted()),
            ])
            ->emptyStateHeading('لا مهام لليوم')
            ->paginated(false);
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('allTasks')
                ->label('كل المهام')
                ->url(GardenTaskResource::getUrl()),
        ];
    }
}
