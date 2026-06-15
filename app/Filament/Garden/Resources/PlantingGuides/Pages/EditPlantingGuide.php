<?php

namespace App\Filament\Garden\Resources\PlantingGuides\Pages;

use App\Filament\Garden\Resources\PlantingGuides\PlantingGuideResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlantingGuide extends EditRecord
{
    protected static string $resource = PlantingGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
