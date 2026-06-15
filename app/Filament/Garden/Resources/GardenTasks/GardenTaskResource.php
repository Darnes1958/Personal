<?php

namespace App\Filament\Garden\Resources\GardenTasks;

use App\Filament\Garden\Resources\GardenTasks\Pages\CreateGardenTask;
use App\Filament\Garden\Resources\GardenTasks\Pages\EditGardenTask;
use App\Filament\Garden\Resources\GardenTasks\Pages\ListGardenTasks;
use App\Filament\Garden\Resources\GardenTasks\Schemas\GardenTaskForm;
use App\Filament\Garden\Resources\GardenTasks\Tables\GardenTasksTable;
use App\Models\GardenTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GardenTaskResource extends Resource
{
    protected static ?string $model = GardenTask::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'المهام';

    protected static ?string $modelLabel = 'مهمة';

    protected static ?string $pluralModelLabel = 'المهام';

    protected static string|UnitEnum|null $navigationGroup = 'المهام';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return GardenTaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GardenTasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGardenTasks::route('/'),
            'create' => CreateGardenTask::route('/create'),
            'edit' => EditGardenTask::route('/{record}/edit'),
        ];
    }
}
