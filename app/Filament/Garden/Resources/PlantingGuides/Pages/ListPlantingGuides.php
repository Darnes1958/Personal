<?php

namespace App\Filament\Garden\Resources\PlantingGuides\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\PlantingGuides\PlantingGuideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlantingGuides extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;
    protected static string $resource = PlantingGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
