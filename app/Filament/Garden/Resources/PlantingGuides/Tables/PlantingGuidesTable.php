<?php

namespace App\Filament\Garden\Resources\PlantingGuides\Tables;

use App\Enums\Garden\PlantCategory;
use App\Models\PlantingGuide;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PlantingGuidesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('المحصول')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('batch_label')
                    ->label('الدفعة')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge(),
                TextColumn::make('planting_start')
                    ->label('زراعة من')
                    ->formatStateUsing(fn (string $state, PlantingGuide $record) => $record->formatMonthDayRange(
                        $record->planting_start,
                        $record->planting_end,
                    )),
                TextColumn::make('harvest_start')
                    ->label('حصاد')
                    ->formatStateUsing(fn (?string $state, PlantingGuide $record) => $record->formatMonthDayRange(
                        $record->harvest_start,
                        $record->harvest_end,
                    ) ?? '—'),
                TextColumn::make('season')
                    ->label('الموسم')
                    ->badge()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options(PlantCategory::class),
                TernaryFilter::make('is_active')
                    ->label('نشط'),
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
