<?php

namespace App\Filament\Garden\Resources\PlantLocations\Pages;

use App\Filament\Garden\Resources\PlantLocations\PlantLocationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlantLocation extends EditRecord
{
    protected static string $resource = PlantLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
