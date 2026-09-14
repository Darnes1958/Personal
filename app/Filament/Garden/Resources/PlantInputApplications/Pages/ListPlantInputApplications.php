<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\PlantInputApplications\PlantInputApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantInputApplications extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;
    protected static string $resource = PlantInputApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
