<?php

namespace App\Filament\Garden\Resources\PlantLocations;

use App\Filament\Garden\Resources\PlantLocations\Pages\CreatePlantLocation;
use App\Filament\Garden\Resources\PlantLocations\Pages\EditPlantLocation;
use App\Filament\Garden\Resources\PlantLocations\Pages\ListPlantLocations;
use App\Filament\Garden\Resources\PlantLocations\Schemas\PlantLocationForm;
use App\Filament\Garden\Resources\PlantLocations\Tables\PlantLocationsTable;
use App\Models\PlantLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantLocationResource extends Resource
{
    protected static ?string $model = PlantLocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'المواقع';

    protected static ?string $modelLabel = 'موقع';

    protected static ?string $pluralModelLabel = 'المواقع';

    protected static string|UnitEnum|null $navigationGroup = 'الإعدادات';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PlantLocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantLocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlantLocations::route('/'),
            'create' => CreatePlantLocation::route('/create'),
            'edit' => EditPlantLocation::route('/{record}/edit'),
        ];
    }
}
