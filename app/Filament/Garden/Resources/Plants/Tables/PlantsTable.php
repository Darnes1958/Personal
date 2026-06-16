<?php

namespace App\Filament\Garden\Resources\Plants\Tables;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use App\Filament\Garden\Resources\PlantEvents\Schemas\PlantEventForm;
use App\Models\Plant;
use App\Models\PlantLocation;
use App\Models\PlantVariety;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->deselectAllRecordsWhenFiltered(false)
            ->columns([
                ImageColumn::make('card_image')
                    ->label('الصورة')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plantVariety.name')
                    ->label('الصنف')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge()
                    ->sortable(),
                TextColumn::make('planted_at')
                    ->label('تاريخ الزراعة')
                    ->date()
                    ->sortable(),
                TextColumn::make('plantLocation.name')
                    ->label('الموقع')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('events_count')
                    ->label('الأحداث')
                    ->counts('events'),
            ])
            ->defaultSort('planted_at', 'desc')
            ->defaultKeySort(false)
            ->filters([
                SelectFilter::make('category')
                    ->label('التصنيف')
                    ->options(PlantCategory::class),
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(PlantStatus::class),
                SelectFilter::make('plant_variety_id')
                    ->label('الصنف')
                    ->options(fn () => PlantVariety::query()->active()->orderBy('name')->pluck('name', 'id')),
                SelectFilter::make('plant_location_id')
                    ->label('الموقع')
                    ->options(fn () => PlantLocation::query()->active()->orderBy('name')->pluck('name', 'id')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('addSharedEvent')
                        ->label('إضافة حدث جماعي')
                        ->icon('heroicon-o-calendar-days')
                        ->modalHeading('إضافة حدث لعدة نباتات')
                        ->modalDescription('يُطبَّق نفس الحدث على جميع النباتات المحددة.')
                        ->schema(PlantEventForm::eventFields(includeSharedImage: true))
                        ->fetchSelectedRecords(false)
                        ->action(function (Collection $records, array $data): void {
                            $plants = Plant::query()
                                ->whereIn('id', $records->all())
                                ->get();

                            DB::transaction(function () use ($plants, $data): void {
                                $imagePath = $data['shared_image'] ?? null;
                                if (is_array($imagePath)) {
                                    $imagePath = $imagePath[array_key_first($imagePath)] ?? null;
                                }

                                foreach ($plants as $plant) {
                                    $event = $plant->events()->create([
                                        'type' => $data['type'],
                                        'event_date' => $data['event_date'],
                                        'notes' => $data['notes'] ?? null,
                                    ]);

                                    if (filled($imagePath)) {
                                        $event->images()->create([
                                            'path' => $imagePath,
                                            'sort_order' => 0,
                                        ]);
                                    }
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('تم إضافة الحدث للنباتات المحددة'),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
