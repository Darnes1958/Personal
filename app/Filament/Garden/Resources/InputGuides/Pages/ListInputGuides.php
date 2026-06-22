<?php

namespace App\Filament\Garden\Resources\InputGuides\Pages;

use App\Filament\Garden\Resources\InputGuides\InputGuideResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInputGuides extends ListRecords
{
    protected static string $resource = InputGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
