<?php

namespace App\Filament\Garden\Resources\PlantSpacings\Pages;

use App\Filament\Garden\Resources\PlantSpacings\PlantSpacingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlantSpacing extends EditRecord
{
    protected static string $resource = PlantSpacingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
