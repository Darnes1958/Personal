<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlantInputApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('plant.name')
                    ->label('النبات')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('inputGuide.name')
                    ->label('من الدليل')
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('applied_at')
                    ->label('التاريخ')
                    ->date()
                    ->sortable(),
                TextColumn::make('phenomenon')
                    ->label('الظاهرة')
                    ->limit(30)
                    ->placeholder('—')
                    ->toggleable(),
                ImageColumn::make('before_images')
                    ->label('قبل')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(2)
                    ->limitedRemainingText()
                    ->imageHeight(36),
                ImageColumn::make('after_images')
                    ->label('بعد')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(2)
                    ->limitedRemainingText()
                    ->imageHeight(36),
            ])
            ->defaultSort('applied_at', 'desc')
            ->filters([
                SelectFilter::make('plant_id')
                    ->label('النبات')
                    ->relationship('plant', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('input_guide_id')
                    ->label('الدليل')
                    ->relationship('inputGuide', 'name')
                    ->searchable()
                    ->preload(),
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
