<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Pages;

use App\Filament\Garden\Resources\PlantInputApplications\PlantInputApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlantInputApplication extends ViewRecord
{
    protected static string $resource = PlantInputApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
