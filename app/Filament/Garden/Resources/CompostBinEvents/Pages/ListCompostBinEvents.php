<?php

namespace App\Filament\Garden\Resources\CompostBinEvents\Pages;

use App\Filament\Garden\Resources\CompostBinEvents\CompostBinEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompostBinEvents extends ListRecords
{
    protected static string $resource = CompostBinEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
