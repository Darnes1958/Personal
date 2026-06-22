<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Pages;

use App\Filament\Garden\Resources\PlantInputApplications\PlantInputApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlantInputApplication extends CreateRecord
{
    protected static string $resource = PlantInputApplicationResource::class;

    public function mount(): void
    {
        parent::mount();

        $plantId = request()->integer('plant_id');
        $inputGuideId = request()->integer('input_guide_id');

        $fill = [];

        if ($plantId) {
            $fill['plant_id'] = $plantId;
        }

        if ($inputGuideId) {
            $fill['input_guide_id'] = $inputGuideId;
        }

        if ($fill !== []) {
            $this->form->fill($fill);
        }
    }
}
