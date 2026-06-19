<?php

namespace App\Filament\Garden\Resources\CompostBinEvents;

use App\Filament\Garden\Resources\CompostBinEvents\Pages\CreateCompostBinEvent;
use App\Filament\Garden\Resources\CompostBinEvents\Pages\EditCompostBinEvent;
use App\Filament\Garden\Resources\CompostBinEvents\Pages\ListCompostBinEvents;
use App\Filament\Garden\Resources\CompostBinEvents\Schemas\CompostBinEventForm;
use App\Filament\Garden\Resources\CompostBinEvents\Tables\CompostBinEventsTable;
use App\Models\CompostBinEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompostBinEventResource extends Resource
{
    protected static ?string $model = CompostBinEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static ?string $navigationLabel = 'أحداث الأحواض';

    protected static ?string $modelLabel = 'حدث';

    protected static ?string $pluralModelLabel = 'أحداث الأحواض';

    protected static string|UnitEnum|null $navigationGroup = 'الكمبوست';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CompostBinEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompostBinEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCompostBinEvents::route('/'),
            'create' => CreateCompostBinEvent::route('/create'),
            'edit' => EditCompostBinEvent::route('/{record}/edit'),
        ];
    }
}
