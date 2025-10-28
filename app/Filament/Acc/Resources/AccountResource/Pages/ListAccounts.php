<?php

namespace App\Filament\Acc\Resources\AccountResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Acc\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccounts extends ListRecords
{
    protected static string $resource = AccountResource::class;
    protected ?string $heading=' ';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('ادخال حساب جديد'),
        ];
    }
}
