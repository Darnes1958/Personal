<?php

namespace App\Filament\Sell\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('invoice_date')
                    ->date(),
                TextEntry::make('bank_id')
                    ->numeric(),
                TextEntry::make('invoice_number')
                    ->numeric(),
                TextEntry::make('specifications'),
                TextEntry::make('engine_number'),
                TextEntry::make('color'),
                TextEntry::make('model'),
                TextEntry::make('chassis_number'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
