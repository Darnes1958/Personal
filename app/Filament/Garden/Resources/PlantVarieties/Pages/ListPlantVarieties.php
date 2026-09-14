<?php

namespace App\Filament\Garden\Resources\PlantVarieties\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\PlantVarieties\PlantVarietyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantVarieties extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;
    protected static string $resource = PlantVarietyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
