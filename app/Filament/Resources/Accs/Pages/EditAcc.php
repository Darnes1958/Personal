<?php

namespace App\Filament\Resources\Accs\Pages;

use App\Filament\Resources\Accs\AccResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAcc extends EditRecord
{
    protected static string $resource = AccResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
