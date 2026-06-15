<?php

namespace App\Filament\Garden\Resources\Plants;

use App\Filament\Garden\Resources\Plants\Pages\CreatePlant;
use App\Filament\Garden\Resources\Plants\Pages\EditPlant;
use App\Filament\Garden\Resources\Plants\Pages\ListPlants;
use App\Filament\Garden\Resources\Plants\Pages\ViewPlant;
use App\Filament\Garden\Resources\Plants\Schemas\PlantForm;
use App\Filament\Garden\Resources\Plants\Schemas\PlantInfolist;
use App\Filament\Garden\Resources\Plants\Tables\PlantsTable;
use App\Models\Plant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantResource extends Resource
{
    protected static ?string $model = Plant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $navigationLabel = 'النباتات';

    protected static ?string $modelLabel = 'نبات';

    protected static ?string $pluralModelLabel = 'النباتات';

    protected static string|UnitEnum|null $navigationGroup = 'النباتات';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PlantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlants::route('/'),
            'create' => CreatePlant::route('/create'),
            'view' => ViewPlant::route('/{record}'),
            'edit' => EditPlant::route('/{record}/edit'),
        ];
    }
}
