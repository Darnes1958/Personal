<?php

namespace App\Filament\Garden\Resources\CompostBinEvents\Tables;

use App\Enums\Garden\CompostBinEventType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompostBinEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('compostBin.name')
                    ->label('الحوض')
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
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('نوع الحدث')
                    ->options(CompostBinEventType::class),
                SelectFilter::make('compost_bin_id')
                    ->label('الحوض')
                    ->relationship('compostBin', 'name')
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
