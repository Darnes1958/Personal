<?php

namespace App\Filament\Garden\Resources\Plants\Pages;

use App\Filament\Garden\Concerns\AvoidsDuplicateOrderByOnSelectedRecords;
use App\Filament\Garden\Resources\ArchivedPlants\ArchivedPlantResource;
use App\Filament\Garden\Resources\Plants\PlantResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlants extends ListRecords
{
    use AvoidsDuplicateOrderByOnSelectedRecords;

    protected static string $resource = PlantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('openArchive')
                ->label('الأرشيف')
                ->icon('heroicon-o-archive-box')
                ->color('gray')
                ->url(ArchivedPlantResource::getUrl()),
            CreateAction::make(),
        ];
    }
}
