<?php

namespace App\Filament\Garden\Resources\PlantEvents\Pages;

use App\Filament\Garden\Resources\PlantEvents\PlantEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlantEvent extends CreateRecord
{
    protected static string $resource = PlantEventResource::class;

    public function mount(): void
    {
        parent::mount();

        $plantId = request()->integer('plant_id');

        if ($plantId) {
            $this->form->fill(['plant_id' => $plantId]);
        }
    }
}
