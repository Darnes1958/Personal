<?php

namespace App\Filament\Garden\Resources\PlantEvents;

use App\Filament\Garden\Resources\PlantEvents\Pages\CreatePlantEvent;
use App\Filament\Garden\Resources\PlantEvents\Pages\EditPlantEvent;
use App\Filament\Garden\Resources\PlantEvents\Pages\ListPlantEvents;
use App\Filament\Garden\Resources\PlantEvents\Schemas\PlantEventForm;
use App\Filament\Garden\Resources\PlantEvents\Tables\PlantEventsTable;
use App\Models\PlantEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantEventResource extends Resource
{
    protected static ?string $model = PlantEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'أحداث النباتات';

    protected static ?string $modelLabel = 'حدث';

    protected static ?string $pluralModelLabel = 'أحداث النباتات';

    protected static string|UnitEnum|null $navigationGroup = 'النباتات';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PlantEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlantEvents::route('/'),
            'create' => CreatePlantEvent::route('/create'),
            'edit' => EditPlantEvent::route('/{record}/edit'),
        ];
    }
}
