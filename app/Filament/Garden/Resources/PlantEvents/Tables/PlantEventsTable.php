<?php

namespace App\Filament\Garden\Resources\PlantEvents\Tables;

use App\Enums\Garden\PlantEventType;
use App\Filament\Garden\Support\GardenFormats;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlantEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plant.name')
                    ->label('النبات')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->sortable(),
                TextColumn::make('event_date')
                    ->label('التاريخ')
                    ->date(GardenFormats::TABLE_DATE)
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->limit(50)
                    ->toggleable(),
                ImageColumn::make('images')
                    ->label('الصور')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->imageHeight(36),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('نوع الحدث')
                    ->options(PlantEventType::class),
                SelectFilter::make('plant_id')
                    ->label('النبات')
                    ->relationship('plant', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
