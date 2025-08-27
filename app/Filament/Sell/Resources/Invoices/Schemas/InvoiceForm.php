<?php

namespace App\Filament\Sell\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('invoice_date')
                    ->required(),
                Select::make('bank_id')
                    ->relationship('Bank', 'name')
                    ->required()
                    ->createOptionForm([
                        TextInput::make('name'),
                    ])
                    ->editOptionForm([
                        TextInput::make('name'),
                    ])
                    ->searchable()
                    ->preload(),
                TextInput::make('invoice_number')
                    ->required()
                    ->numeric(),
                TextInput::make('specifications')
                    ->required(),
                TextInput::make('engine_number')
                    ->required(),
                TextInput::make('color')
                    ->required(),
                TextInput::make('model')
                    ->required(),
                TextInput::make('chassis_number')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
