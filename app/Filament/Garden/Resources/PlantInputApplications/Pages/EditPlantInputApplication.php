<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Pages;

use App\Filament\Garden\Resources\PlantInputApplications\PlantInputApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlantInputApplication extends EditRecord
{
    protected static string $resource = PlantInputApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
