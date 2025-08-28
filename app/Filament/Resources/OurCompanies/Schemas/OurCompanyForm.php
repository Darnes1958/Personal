<?php

namespace App\Filament\Resources\OurCompanies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OurCompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('Company'),
                TextInput::make('CompanyName')
                    ->required(),
                TextInput::make('CompanyNameSuffix')
                    ->required(),
                TextInput::make('CompanyImg'),
                TextInput::make('CompCode')
                    ->numeric(),
            ]);
    }
}
