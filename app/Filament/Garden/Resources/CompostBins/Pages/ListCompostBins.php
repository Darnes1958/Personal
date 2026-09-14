<?php

namespace App\Filament\Garden\Resources\CompostBins\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\CompostBins\CompostBinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompostBins extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;
    protected static string $resource = CompostBinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
