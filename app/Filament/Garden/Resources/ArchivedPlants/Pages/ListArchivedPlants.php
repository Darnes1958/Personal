<?php

namespace App\Filament\Garden\Resources\ArchivedPlants\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\ArchivedPlants\ArchivedPlantResource;
use Filament\Resources\Pages\ListRecords;

class ListArchivedPlants extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;

    protected static string $resource = ArchivedPlantResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
