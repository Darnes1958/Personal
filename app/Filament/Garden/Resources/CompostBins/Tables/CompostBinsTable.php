<?php

namespace App\Filament\Garden\Resources\CompostBins\Tables;

use App\Enums\Garden\CompostBinEventType;
use App\Enums\Garden\CompostBinStage;
use App\Enums\Garden\CompostMaterialType;
use App\Filament\Garden\Resources\CompostBinEvents\CompostBinEventResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompostBinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('material_type')
                    ->label('المادة')
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('stage')
                    ->label('المرحلة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('stage_started_at')
                    ->label('بداية المرحلة')
                    ->date()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('days_in_stage')
                    ->label('أيام في المرحلة')
                    ->state(fn ($record) => $record->daysInStage())
                    ->suffix(' يوم')
                    ->placeholder('—'),
                TextColumn::make('plantLocation.name')
                    ->label('الموقع')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('events_count')
                    ->label('الأحداث')
                    ->counts('events'),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('stage')
                    ->label('المرحلة')
                    ->options(CompostBinStage::class),
                SelectFilter::make('material_type')
                    ->label('نوع المادة')
                    ->options(CompostMaterialType::class),
                SelectFilter::make('plant_location_id')
                    ->label('الموقع')
                    ->relationship('plantLocation', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                Action::make('logTurning')
                    ->label('تقليب')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->visible(fn ($record) => in_array($record->stage, [
                        CompostBinStage::Filling,
                        CompostBinStage::Turning,
                    ], true))
                    ->action(function ($record): void {
                        $record->events()->create([
                            'type' => CompostBinEventType::Turning,
                            'event_date' => now(),
                        ]);

                        Notification::make()
                            ->title('تم تسجيل التقليب')
                            ->success()
                            ->send();
                    }),
                Action::make('logWatering')
                    ->label('رش ماء')
                    ->icon('heroicon-o-cloud')
                    ->color('primary')
                    ->visible(fn ($record) => in_array($record->stage, [
                        CompostBinStage::Turning,
                        CompostBinStage::Fermenting,
                    ], true))
                    ->action(function ($record): void {
                        $record->events()->create([
                            'type' => CompostBinEventType::Watering,
                            'event_date' => now(),
                        ]);

                        Notification::make()
                            ->title('تم تسجيل رش الماء')
                            ->success()
                            ->send();
                    }),
                Action::make('addEvent')
                    ->label('حدث')
                    ->icon('heroicon-o-plus')
                    ->url(fn ($record) => CompostBinEventResource::getUrl('create', [
                        'compost_bin_id' => $record->id,
                    ])),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
