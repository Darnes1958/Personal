<?php

namespace App\Filament\Garden\Resources\Plants\Pages;

use App\Filament\Garden\Resources\PlantEvents\PlantEventResource;
use App\Filament\Garden\Resources\Plants\PlantResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlant extends ViewRecord
{
    protected static string $resource = PlantResource::class;

    protected function resolveRecord(int|string $key): \Illuminate\Database\Eloquent\Model
    {
        return parent::resolveRecord($key)->load([
            'events',
            'plantingGuide',
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('addEvent')
                ->label('تسجيل حدث')
                ->icon('heroicon-o-plus')
                ->url(fn () => PlantEventResource::getUrl('create', ['plant_id' => $this->record->id])),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
