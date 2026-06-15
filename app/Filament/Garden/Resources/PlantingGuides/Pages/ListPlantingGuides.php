<?php

namespace App\Filament\Garden\Resources\PlantingGuides\Pages;

use App\Filament\Garden\Resources\PlantingGuides\PlantingGuideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantingGuides extends ListRecords
{
    protected static string $resource = PlantingGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
