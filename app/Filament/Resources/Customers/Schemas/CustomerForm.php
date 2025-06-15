<?php

namespace App\Filament\Resources\Customers\Schemas;

use App\Enums\Kind;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                TextInput::make('email')

                    ->email(),
                TextInput::make('tel1')

                    ->tel(),
                TextInput::make('tel2')

                    ->tel(),
                TextInput::make('other'),
                TextInput::make('address'),
                Toggle::make('visible')

                    ->default(1)
                    ->visible(function ($operation){
                        return $operation=='edit';
                    })
                    ->required(),
                Radio::make('kind')


                    ->options(Kind::class)
                    ->required()
                    ->default(0),
                Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }
}
