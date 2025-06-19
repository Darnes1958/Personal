<?php

namespace App\Filament\Resources\Accs\Schemas;

use App\Enums\AccKind;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AccForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('acc_num'),
                Select::make('kind')
                    ->options(AccKind::class)
                    ->required(),
                TextInput::make('previous_balance')
                    ->required()
                    ->numeric()
                    ->default(0),
                Hidden::make('user_id')

                    ->default(fn()=>Auth::id()),
            ]);
    }
}
