<?php

namespace App\Filament\Resources\OurCompanies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OurCompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Company')
                    ->searchable(),
                TextColumn::make('CompanyName')
                    ->searchable(),
                TextColumn::make('CompanyNameSuffix')
                    ->searchable(),
                TextColumn::make('CompanyImg')
                    ->searchable(),
                TextColumn::make('CompCode')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
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
