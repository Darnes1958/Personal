<?php

namespace App\Filament\Garden\Resources\InputGuides;

use App\Filament\Garden\Resources\InputGuides\Pages\CreateInputGuide;
use App\Filament\Garden\Resources\InputGuides\Pages\EditInputGuide;
use App\Filament\Garden\Resources\InputGuides\Pages\ListInputGuides;
use App\Filament\Garden\Resources\InputGuides\Schemas\InputGuideForm;
use App\Filament\Garden\Resources\InputGuides\Tables\InputGuidesTable;
use App\Models\InputGuide;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InputGuideResource extends Resource
{
    protected static ?string $model = InputGuide::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static ?string $navigationLabel = 'دليل الأسمدة والمبيدات';

    protected static ?string $modelLabel = 'دليل';

    protected static ?string $pluralModelLabel = 'دليل الأسمدة والمبيدات';

    protected static string|UnitEnum|null $navigationGroup = 'التغذية والوقاية';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return InputGuideForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InputGuidesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInputGuides::route('/'),
            'create' => CreateInputGuide::route('/create'),
            'edit' => EditInputGuide::route('/{record}/edit'),
        ];
    }
}
