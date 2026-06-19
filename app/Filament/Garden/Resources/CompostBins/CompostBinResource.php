<?php

namespace App\Filament\Garden\Resources\CompostBins;

use App\Filament\Garden\Resources\CompostBins\Pages\CreateCompostBin;
use App\Filament\Garden\Resources\CompostBins\Pages\EditCompostBin;
use App\Filament\Garden\Resources\CompostBins\Pages\ListCompostBins;
use App\Filament\Garden\Resources\CompostBins\Pages\ViewCompostBin;
use App\Filament\Garden\Resources\CompostBins\Schemas\CompostBinForm;
use App\Filament\Garden\Resources\CompostBins\Schemas\CompostBinInfolist;
use App\Filament\Garden\Resources\CompostBins\Tables\CompostBinsTable;
use App\Models\CompostBin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompostBinResource extends Resource
{
    protected static ?string $model = CompostBin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $navigationLabel = 'أحواض السماد';

    protected static ?string $modelLabel = 'حوض';

    protected static ?string $pluralModelLabel = 'أحواض السماد';

    protected static string|UnitEnum|null $navigationGroup = 'الكمبوست';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CompostBinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CompostBinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompostBinsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompostBins::route('/'),
            'create' => CreateCompostBin::route('/create'),
            'view' => ViewCompostBin::route('/{record}'),
            'edit' => EditCompostBin::route('/{record}/edit'),
        ];
    }
}
