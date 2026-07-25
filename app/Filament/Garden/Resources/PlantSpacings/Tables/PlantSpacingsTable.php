<?php

namespace App\Filament\Garden\Resources\PlantSpacings\Tables;

use App\Models\PlantSpacing;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlantSpacingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plantingGuide.name')
                    ->label('المحصول')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plantingGuide.batch_label')
                    ->label('الدفعة')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('row_spacing_from_cm')
                    ->label('بين الخطوط')
                    ->state(fn (PlantSpacing $record): ?string => $record->rowSpacingLabel())
                    ->sortable(),
                TextColumn::make('plant_spacing_from_cm')
                    ->label('بين النباتات')
                    ->state(fn (PlantSpacing $record): ?string => $record->plantSpacingLabel())
                    ->sortable(),
                TextColumn::make('depth_from_cm')
                    ->label('العمق')
                    ->state(fn (PlantSpacing $record): ?string => $record->depthLabel())
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->limit(40)
                    ->placeholder('—')
                    ->toggleable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('planting_guide_id')
                    ->label('المحصول')
                    ->relationship('plantingGuide', 'name')
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
