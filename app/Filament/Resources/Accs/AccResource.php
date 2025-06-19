<?php

namespace App\Filament\Resources\Accs;

use App\Filament\Resources\Accs\Pages\CreateAcc;
use App\Filament\Resources\Accs\Pages\EditAcc;
use App\Filament\Resources\Accs\Pages\ListAccs;
use App\Filament\Resources\Accs\Pages\ViewAcc;
use App\Filament\Resources\Accs\Schemas\AccForm;
use App\Filament\Resources\Accs\Schemas\AccInfolist;
use App\Filament\Resources\Accs\Tables\AccsTable;
use App\Models\Acc;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AccResource extends Resource
{
    protected static ?string $model = Acc::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AccForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AccInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AccsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Acc');
    }
    public static function getPluralModelLabel(): string
    {
        return __('Accs');
    }
    public static function getPages(): array
    {
        return [
            'index' => ListAccs::route('/'),
            'create' => CreateAcc::route('/create'),
            'view' => ViewAcc::route('/{record}'),
            'edit' => EditAcc::route('/{record}/edit'),
        ];
    }
}
