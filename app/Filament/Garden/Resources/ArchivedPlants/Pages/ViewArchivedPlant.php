<?php

namespace App\Filament\Garden\Resources\ArchivedPlants\Pages;

use App\Filament\Garden\Resources\ArchivedPlants\ArchivedPlantResource;
use App\Filament\Garden\Support\PlantArchiveActions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArchivedPlant extends ViewRecord
{
    protected static string $resource = ArchivedPlantResource::class;

    protected function resolveRecord(int|string $key): \Illuminate\Database\Eloquent\Model
    {
        return parent::resolveRecord($key)->loadForView();
    }

    protected function getHeaderActions(): array
    {
        return [
            PlantArchiveActions::restoreAction(),
            DeleteAction::make()
                ->label('حذف نهائي')
                ->modalHeading('حذف نهائي من الأرشيف؟')
                ->modalDescription('سيُحذف النبات وأحداثه وتطبيقاته نهائياً ولا يمكن التراجع.'),
        ];
    }
}
