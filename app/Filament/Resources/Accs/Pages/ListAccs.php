<?php

namespace App\Filament\Resources\Accs\Pages;

use App\Filament\Resources\Accs\AccResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccs extends ListRecords
{
    protected static string $resource = AccResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
