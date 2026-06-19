<?php

namespace App\Filament\Garden\Resources\CompostBinEvents\Pages;

use App\Filament\Garden\Resources\CompostBinEvents\CompostBinEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCompostBinEvent extends CreateRecord
{
    protected static string $resource = CompostBinEventResource::class;

    public function mount(): void
    {
        parent::mount();

        $compostBinId = request()->integer('compost_bin_id');

        if ($compostBinId) {
            $this->form->fill(['compost_bin_id' => $compostBinId]);
        }
    }
}
