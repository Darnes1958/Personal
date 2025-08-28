<?php

namespace App\Filament\Resources\OurCompanies;

use App\Filament\Resources\OurCompanies\Pages\CreateOurCompany;
use App\Filament\Resources\OurCompanies\Pages\EditOurCompany;
use App\Filament\Resources\OurCompanies\Pages\ListOurCompanies;
use App\Filament\Resources\OurCompanies\Schemas\OurCompanyForm;
use App\Filament\Resources\OurCompanies\Tables\OurCompaniesTable;
use App\Models\OurCompany;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class OurCompanyResource extends Resource
{
    protected static ?string $model = OurCompany::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::id()==1;
    }

    public static function form(Schema $schema): Schema
    {
        return OurCompanyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OurCompaniesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOurCompanies::route('/'),
            'create' => CreateOurCompany::route('/create'),
            'edit' => EditOurCompany::route('/{record}/edit'),
        ];
    }
}
