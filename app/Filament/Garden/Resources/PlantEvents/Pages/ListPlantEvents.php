<?php

namespace App\Filament\Garden\Resources\PlantEvents\Pages;

use App\Filament\Garden\Resources\PlantEvents\PlantEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantEvents extends ListRecords
{
    protected static string $resource = PlantEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
