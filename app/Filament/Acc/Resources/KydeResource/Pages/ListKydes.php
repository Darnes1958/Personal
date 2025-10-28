<?php

namespace App\Filament\Acc\Resources\KydeResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Acc\Resources\KydeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKydes extends ListRecords
{
    protected static string $resource = KydeResource::class;
    protected ?string $heading=' ';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('ادخال قيد'),
        ];
    }
}
