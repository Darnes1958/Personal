<?php

namespace App\Filament\Garden\Resources\PlantEvents\Tables;

use App\Enums\Garden\PlantEventType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->date()
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('images_count')
                    ->label('الصور')
                    ->counts('images')
                    ->sortable(),
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
