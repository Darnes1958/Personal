<?php

namespace App\Filament\Garden\Resources\PlantVarieties;

use App\Filament\Garden\Resources\PlantVarieties\Pages\CreatePlantVariety;
use App\Filament\Garden\Resources\PlantVarieties\Pages\EditPlantVariety;
use App\Filament\Garden\Resources\PlantVarieties\Pages\ListPlantVarieties;
use App\Filament\Garden\Resources\PlantVarieties\Schemas\PlantVarietyForm;
use App\Filament\Garden\Resources\PlantVarieties\Tables\PlantVarietiesTable;
use App\Models\PlantVariety;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantVarietyResource extends Resource
{
    protected static ?string $model = PlantVariety::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'الأصناف';

    protected static ?string $modelLabel = 'صنف';

    protected static ?string $pluralModelLabel = 'الأصناف';

    protected static string|UnitEnum|null $navigationGroup = 'الإعدادات';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PlantVarietyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantVarietiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlantVarieties::route('/'),
            'create' => CreatePlantVariety::route('/create'),
            'edit' => EditPlantVariety::route('/{record}/edit'),
        ];
    }
}
