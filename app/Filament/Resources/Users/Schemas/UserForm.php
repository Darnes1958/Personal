<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\hisSystem;
use App\Models\OurCompany;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('hisSystem')
                    ->options(hisSystem::class),
                Toggle::make('is_programmer')
                    ->label('مطوّر')
                    ->default(false),
                Select::make('company')
                    ->searchable()
                    ->preload()
                    ->options(OurCompany::all()->pluck('Company', 'Company')),


            ]);
    }
}
