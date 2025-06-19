<?php

namespace App\Filament\Resources\Accs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AccInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('acc_num'),
                TextEntry::make('kind')
                    ,
                TextEntry::make('previous_balance')
                    ->numeric(locale: 'nl'),
                TextEntry::make('User.name')
                ->translateLabel(false)
                ->visible(fn()=>Auth::id()==1),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
