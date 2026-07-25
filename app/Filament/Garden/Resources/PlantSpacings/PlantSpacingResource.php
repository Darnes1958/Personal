<?php

namespace App\Filament\Garden\Resources\PlantSpacings;

use App\Filament\Garden\Resources\PlantSpacings\Pages\CreatePlantSpacing;
use App\Filament\Garden\Resources\PlantSpacings\Pages\EditPlantSpacing;
use App\Filament\Garden\Resources\PlantSpacings\Pages\ListPlantSpacings;
use App\Filament\Garden\Resources\PlantSpacings\Schemas\PlantSpacingForm;
use App\Filament\Garden\Resources\PlantSpacings\Tables\PlantSpacingsTable;
use App\Models\PlantSpacing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantSpacingResource extends Resource
{
    protected static ?string $model = PlantSpacing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?string $navigationLabel = 'المسافات بين النباتات';

    protected static ?string $modelLabel = 'مسافة زراعة';

    protected static ?string $pluralModelLabel = 'المسافات بين النباتات';

    protected static string|UnitEnum|null $navigationGroup = 'الدليل';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PlantSpacingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantSpacingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlantSpacings::route('/'),
            'create' => CreatePlantSpacing::route('/create'),
            'edit' => EditPlantSpacing::route('/{record}/edit'),
        ];
    }
}
