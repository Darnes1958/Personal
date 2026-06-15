<?php

namespace App\Filament\Garden\Resources\Plants\Pages;

use App\Filament\Garden\Resources\Plants\PlantResource;
use App\Models\PlantingGuide;
use Filament\Resources\Pages\CreateRecord;

class CreatePlant extends CreateRecord
{
    protected static string $resource = PlantResource::class;

    public function mount(): void
    {
        parent::mount();

        $guideId = request()->integer('planting_guide_id');

        if (! $guideId) {
            return;
        }

        $guide = PlantingGuide::find($guideId);

        if (! $guide) {
            return;
        }

        $this->form->fill([
            'planting_guide_id' => $guideId,
            'name' => $guide->batch_label
                ? "{$guide->name} — {$guide->batch_label}"
                : $guide->name,
            'category' => $guide->category,
            'planted_at' => now(),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (filled($data['planting_guide_id'] ?? null) && blank($data['name'] ?? null)) {
            $guide = PlantingGuide::find($data['planting_guide_id']);
            if ($guide) {
                $data['name'] = $guide->batch_label
                    ? "{$guide->name} — {$guide->batch_label}"
                    : $guide->name;
                $data['category'] ??= $guide->category;
            }
        }

        return $data;
    }
}
