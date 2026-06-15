<?php

namespace App\Filament\Garden\Resources\PlantVarieties\Pages;

use App\Filament\Garden\Resources\PlantVarieties\PlantVarietyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlantVariety extends EditRecord
{
    protected static string $resource = PlantVarietyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
