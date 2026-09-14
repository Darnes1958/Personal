<?php

namespace App\Filament\Garden\Resources\ArchivedPlants\Tables;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use App\Filament\Garden\Support\GardenFormats;
use App\Filament\Garden\Support\PlantArchiveActions;
use App\Models\PlantLocation;
use App\Models\PlantVariety;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArchivedPlantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deselectAllRecordsWhenFiltered(false)
            ->columns([
                ImageColumn::make('card_image')
                    ->label('الصور')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->imageHeight(40),
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plantVariety.name')
                    ->label('الصنف')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge()
                    ->sortable(),
                TextColumn::make('planted_at')
                    ->label('تاريخ الزراعة')
                    ->date(GardenFormats::TABLE_DATE)
                    ->sortable(),
                TextColumn::make('archived_at')
                    ->label('تاريخ الأرشفة')
                    ->date(GardenFormats::TABLE_DATE)
                    ->sortable(),
                TextColumn::make('archive_reason')
                    ->label('سبب الإزالة')
                    ->limit(40)
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('plantLocation.name')
                    ->label('الموقع')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('events_count')
                    ->label('الأحداث')
                    ->counts('events'),
            ])
            ->defaultSort('archived_at', 'desc')
            ->defaultKeySort(false)
            ->filters([
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options(PlantCategory::class),
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(PlantStatus::class),
                SelectFilter::make('plant_variety_id')
                    ->label('الصنف')
                    ->options(fn () => PlantVariety::query()->orderBy('name')->pluck('name', 'id')),
                SelectFilter::make('plant_location_id')
                    ->label('الموقع')
                    ->options(fn () => PlantLocation::query()->orderBy('name')->pluck('name', 'id')),
            ])
            ->recordActions([
                ViewAction::make(),
                PlantArchiveActions::restoreAction(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    PlantArchiveActions::restoreBulkAction(),
                    DeleteBulkAction::make()
                        ->label('حذف نهائي')
                        ->modalHeading('حذف نهائي من الأرشيف؟')
                        ->modalDescription('سيُحذف النبات وأحداثه وتطبيقاته نهائياً ولا يمكن التراجع.'),
                ]),
            ]);
    }
}
