<?php

namespace App\Filament\Garden\Resources\GardenTasks\Pages;

use App\Filament\Garden\Resources\GardenTasks\GardenTaskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGardenTask extends CreateRecord
{
    protected static string $resource = GardenTaskResource::class;

    public function mount(): void
    {
        parent::mount();

        $plantId = request()->integer('plant_id');

        if ($plantId) {
            $this->form->fill(['plant_id' => $plantId]);
        }
    }
}
