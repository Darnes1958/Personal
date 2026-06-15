<?php

namespace App\Filament\Garden\Resources\GardenTasks\Pages;

use App\Filament\Garden\Resources\GardenTasks\GardenTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGardenTask extends EditRecord
{
    protected static string $resource = GardenTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
