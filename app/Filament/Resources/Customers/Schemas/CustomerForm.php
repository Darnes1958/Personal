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
                    ->label('الإسم')
                    ->required(),
                TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email(),
                TextInput::make('tel1')
                    ->label('هاتف 1')
                    ->tel(),
                TextInput::make('tel2')
                    ->label('هاتف 2')
                    ->tel(),
                TextInput::make('other')->label('بيانات أخري'),
                TextInput::make('address')->label('العنوان'),
                Toggle::make('visible')
                    ->label('فعال')
                    ->default(1)
                    ->visible(function ($operation){
                        return $operation=='edit';
                    })
                    ->required(),
                Radio::make('kind')
                    ->label('التصنيف')

                    ->options(Kind::class)
                    ->required()
                    ->default(0),
                Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }
}
