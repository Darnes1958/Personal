<?php

namespace App\Filament\Garden\Resources\PlantEvents\Pages;

use App\Filament\Garden\Resources\PlantEvents\PlantEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlantEvent extends EditRecord
{
    protected static string $resource = PlantEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
