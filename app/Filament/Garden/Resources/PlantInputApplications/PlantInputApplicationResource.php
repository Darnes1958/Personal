<?php

namespace App\Filament\Garden\Resources\PlantInputApplications;

use App\Filament\Garden\Resources\PlantInputApplications\Pages\CreatePlantInputApplication;
use App\Filament\Garden\Resources\PlantInputApplications\Pages\EditPlantInputApplication;
use App\Filament\Garden\Resources\PlantInputApplications\Pages\ListPlantInputApplications;
use App\Filament\Garden\Resources\PlantInputApplications\Pages\ViewPlantInputApplication;
use App\Filament\Garden\Resources\PlantInputApplications\Schemas\PlantInputApplicationForm;
use App\Filament\Garden\Resources\PlantInputApplications\Schemas\PlantInputApplicationInfolist;
use App\Filament\Garden\Resources\PlantInputApplications\Tables\PlantInputApplicationsTable;
use App\Models\PlantInputApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlantInputApplicationResource extends Resource
{
    protected static ?string $model = PlantInputApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'تطبيقات الأسمدة والمبيدات';

    protected static ?string $modelLabel = 'تطبيق';

    protected static ?string $pluralModelLabel = 'تطبيقات الأسمدة والمبيدات';

    protected static string|UnitEnum|null $navigationGroup = 'التغذية والوقاية';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PlantInputApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlantInputApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlantInputApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlantInputApplications::route('/'),
            'create' => CreatePlantInputApplication::route('/create'),
            'view' => ViewPlantInputApplication::route('/{record}'),
            'edit' => EditPlantInputApplication::route('/{record}/edit'),
        ];
    }
}
