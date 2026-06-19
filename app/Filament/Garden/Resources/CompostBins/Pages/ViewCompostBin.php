<?php

namespace App\Filament\Garden\Resources\CompostBins\Pages;

use App\Enums\Garden\CompostBinEventType;
use App\Enums\Garden\CompostBinStage;
use App\Filament\Garden\Resources\CompostBinEvents\CompostBinEventResource;
use App\Filament\Garden\Resources\CompostBins\CompostBinResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewCompostBin extends ViewRecord
{
    protected static string $resource = CompostBinResource::class;

    protected function resolveRecord(int|string $key): \Illuminate\Database\Eloquent\Model
    {
        return parent::resolveRecord($key)->load([
            'events' => fn ($query) => $query->orderByDesc('event_date')->orderByDesc('id'),
            'plantLocation',
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('logTurning')
                ->label('تسجيل تقليب')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn () => in_array($this->record->stage, [
                    CompostBinStage::Filling,
                    CompostBinStage::Turning,
                ], true))
                ->action(function (): void {
                    $this->record->events()->create([
                        'type' => CompostBinEventType::Turning,
                        'event_date' => now(),
                    ]);

                    $this->record->load([
                        'events' => fn ($query) => $query->orderByDesc('event_date')->orderByDesc('id'),
                    ]);

                    Notification::make()
                        ->title('تم تسجيل التقليب')
                        ->success()
                        ->send();
                }),
            Action::make('addEvent')
                ->label('تسجيل حدث')
                ->icon('heroicon-o-plus')
                ->url(fn () => CompostBinEventResource::getUrl('create', [
                    'compost_bin_id' => $this->record->id,
                ])),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
