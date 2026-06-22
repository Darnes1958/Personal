<?php

namespace App\Filament\Garden\Resources\InputGuides\Pages;

use App\Filament\Garden\Resources\InputGuides\InputGuideResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInputGuide extends EditRecord
{
    protected static string $resource = InputGuideResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
