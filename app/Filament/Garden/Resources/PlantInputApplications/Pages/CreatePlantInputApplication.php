<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Pages;

use App\Filament\Garden\Resources\PlantInputApplications\PlantInputApplicationResource;
use App\Models\PlantInputApplication;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePlantInputApplication extends CreateRecord
{
    protected static string $resource = PlantInputApplicationResource::class;

    protected int $createdCount = 1;

    public function mount(): void
    {
        parent::mount();

        $plantId = request()->integer('plant_id');
        $inputGuideId = request()->integer('input_guide_id');

        $fill = [];

        if ($plantId) {
            $fill['plant_ids'] = [$plantId];
        }

        if ($inputGuideId) {
            $fill['input_guide_id'] = $inputGuideId;
        }

        if ($fill !== []) {
            $this->form->fill($fill);
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        $plantIds = $data['plant_ids'] ?? [];
        unset($data['plant_ids']);

        $this->createdCount = count($plantIds);

        $record = null;

        DB::transaction(function () use ($plantIds, $data, &$record): void {
            foreach ($plantIds as $plantId) {
                $created = PlantInputApplication::create([
                    ...$data,
                    'plant_id' => $plantId,
                ]);

                $record ??= $created;
            }
        });

        return $record;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        if ($this->createdCount > 1) {
            return "تم إنشاء {$this->createdCount} تطبيقات";
        }

        return parent::getCreatedNotificationTitle();
    }
}
