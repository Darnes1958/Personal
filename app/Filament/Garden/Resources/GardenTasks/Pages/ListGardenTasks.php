<?php

namespace App\Filament\Garden\Resources\GardenTasks\Pages;

use App\Filament\Garden\Resources\GardenTasks\GardenTaskResource;
use App\Models\GardenTask;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGardenTasks extends ListRecords
{
    protected static string $resource = GardenTaskResource::class;

    public function mount(): void
    {
        GardenTask::refreshOverdue();

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
