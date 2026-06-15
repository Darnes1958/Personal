<?php

namespace App\Filament\Garden\Resources\Plants\Tables;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('card_image')
                    ->label('الصورة')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('variety')
                    ->label('الصنف')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge()
                    ->sortable(),
                TextColumn::make('planted_at')
                    ->label('تاريخ الزراعة')
                    ->date()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('الموقع')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('events_count')
                    ->label('الأحداث')
                    ->counts('events')
                    ->sortable(),
            ])
            ->defaultSort('planted_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options(PlantCategory::class),
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(PlantStatus::class),
            ])
            ->recordActions([
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
