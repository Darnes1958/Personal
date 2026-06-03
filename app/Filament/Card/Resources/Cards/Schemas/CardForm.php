<?php

namespace App\Filament\Card\Resources\Cards\Schemas;

use App\Models\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ser')
                    ->default(fn()=>Card::max('ser') + 1)
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('card_no')
                    ->required()
                    ->numeric(),
                TextInput::make('nation_id')
                    ->required()
                    ->numeric(),
                TextInput::make('id_no')
                    ->required(),
                DatePicker::make('card_date')
                    ->required(),
                TextInput::make('ical_no')
                    ->required()
                    ->numeric(),
                TextInput::make('notes'),

            ]);
    }
}
