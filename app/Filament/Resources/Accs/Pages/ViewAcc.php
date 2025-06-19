<?php

namespace App\Filament\Resources\Accs\Pages;

use App\Filament\Resources\Accs\AccResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAcc extends ViewRecord
{
    protected static string $resource = AccResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
