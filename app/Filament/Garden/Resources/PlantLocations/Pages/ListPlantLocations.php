<?php

namespace App\Filament\Garden\Resources\PlantLocations\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\PlantLocations\PlantLocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantLocations extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;
    protected static string $resource = PlantLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
