<?php

namespace App\Filament\Garden\Resources\PlantSpacings\Pages;

use App\Filament\Garden\Resources\PlantSpacings\PlantSpacingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantSpacings extends ListRecords
{
    protected static string $resource = PlantSpacingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
