<?php

namespace App\Filament\Garden\Resources\GardenTasks\Tables;

use App\Enums\Garden\GardenTaskStatus;
use App\Enums\Garden\GardenTaskType;
use App\Filament\Garden\Support\GardenFormats;
use App\Models\GardenTask;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class GardenTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plant.name')
                    ->label('النبات')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),
                TextColumn::make('due_date')
                    ->label('الموعد')
                    ->date(GardenFormats::TABLE_DATE)
                    ->sortable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->sortable(),
            ])
            ->defaultSort('due_date')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(GardenTaskStatus::class),
                SelectFilter::make('type')
                    ->label('النوع')
                    ->options(GardenTaskType::class),
            ])
            ->recordActions([
                Action::make('complete')
                    ->label('تم')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (GardenTask $record) => $record->status !== GardenTaskStatus::Completed)
                    ->action(fn (GardenTask $record) => $record->markCompleted()),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
