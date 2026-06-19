<?php

namespace App\Filament\Garden\Resources\CompostBins\Pages;

use App\Filament\Garden\Resources\CompostBins\CompostBinResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompostBin extends EditRecord
{
    protected static string $resource = CompostBinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
