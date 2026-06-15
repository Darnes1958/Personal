<?php

namespace App\Filament\Garden\Resources\PlantingGuides;

use App\Filament\Garden\Resources\PlantingGuides\Pages\CreatePlantingGuide;
use App\Filament\Garden\Resources\PlantingGuides\Pages\EditPlantingGuide;
use App\Filament\Garden\Resources\PlantingGuides\Pages\ListPlantingGuides;
use App\Filament\Garden\Resources\PlantingGuides\Schemas\PlantingGuideForm;
use App\Filament\Garden\Resources\PlantingGuides\Tables\PlantingGuidesTable;
use App\Models\PlantingGuide;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantingGuideResource extends Resource
{
    protected static ?string $model = PlantingGuide::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'دليل الزراعة';

    protected static ?string $modelLabel = 'دليل';

    protected static ?string $pluralModelLabel = 'دليل الزراعة';

    protected static string|UnitEnum|null $navigationGroup = 'الدليل';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PlantingGuideForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantingGuidesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlantingGuides::route('/'),
            'create' => CreatePlantingGuide::route('/create'),
            'edit' => EditPlantingGuide::route('/{record}/edit'),
        ];
    }
}
