<?php

namespace App\Filament\Resources\OurCompanies\Pages;

use App\Filament\Resources\OurCompanies\OurCompanyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOurCompany extends EditRecord
{
    protected static string $resource = OurCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
