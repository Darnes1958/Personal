<?php

namespace App\Filament\Garden\Resources\ArchivedPlants;

use App\Filament\Garden\Resources\ArchivedPlants\Pages\ListArchivedPlants;
use App\Filament\Garden\Resources\ArchivedPlants\Pages\ViewArchivedPlant;
use App\Filament\Garden\Resources\ArchivedPlants\Tables\ArchivedPlantsTable;
use App\Filament\Garden\Resources\Plants\Schemas\PlantInfolist;
use App\Models\Plant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ArchivedPlantResource extends Resource
{
    protected static ?string $model = Plant::class;

    protected static ?string $slug = 'archived-plants';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $navigationLabel = 'الأرشيف';

    protected static ?string $modelLabel = 'نبات مؤرشف';

    protected static ?string $pluralModelLabel = 'الأرشيف';

    protected static string|UnitEnum|null $navigationGroup = 'النباتات';

    protected static ?int $navigationSort = 10;

    protected static bool $isGloballySearchable = false;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->onlyArchived();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlantInfolist::configure($schema, forArchive: true);
    }

    public static function table(Table $table): Table
    {
        return ArchivedPlantsTable::configure($table);
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Plant::query()->onlyArchived()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArchivedPlants::route('/'),
            'view' => ViewArchivedPlant::route('/{record}'),
        ];
    }
}
