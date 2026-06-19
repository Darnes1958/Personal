<?php

namespace App\Filament\Garden\Resources\CompostBinEvents\Pages;

use App\Filament\Garden\Resources\CompostBinEvents\CompostBinEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompostBinEvent extends EditRecord
{
    protected static string $resource = CompostBinEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
