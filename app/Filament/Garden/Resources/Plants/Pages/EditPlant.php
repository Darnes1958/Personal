<?php

namespace App\Filament\Garden\Resources\Plants\Pages;

use App\Filament\Garden\Resources\Plants\PlantResource;
use App\Filament\Garden\Support\PlantArchiveActions;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPlant extends EditRecord
{
    protected static string $resource = PlantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            PlantArchiveActions::archiveAction(),
        ];
    }
}
