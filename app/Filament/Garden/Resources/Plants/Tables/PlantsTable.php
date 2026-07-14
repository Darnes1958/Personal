<?php

namespace App\Filament\Garden\Resources\Plants\Tables;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use App\Filament\Garden\Resources\PlantEvents\Schemas\PlantEventForm;
use App\Filament\Garden\Support\GardenFormats;
use App\Filament\Garden\Resources\PlantInputApplications\Schemas\PlantInputApplicationForm;
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
                    ->label('الصور')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->imageHeight(40),
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
                    ->date(GardenFormats::TABLE_DATE)
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
                                $imagePaths = $data['shared_images'] ?? null;

                                if (! is_array($imagePaths)) {
                                    $imagePaths = filled($imagePaths) ? [$imagePaths] : null;
                                }

                                foreach ($plants as $plant) {
                                    $plant->events()->create([
                                        'type' => $data['type'],
                                        'event_date' => $data['event_date'],
                                        'notes' => $data['notes'] ?? null,
                                        'images' => filled($imagePaths) ? array_values($imagePaths) : null,
                                    ]);
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('تم إضافة الحدث للنباتات المحددة'),
                    BulkAction::make('addSharedInputApplication')
                        ->label('تطبيق تغذية/وقاية جماعي')
                        ->icon('heroicon-o-beaker')
                        ->modalHeading('تطبيق تغذية أو وقاية لعدة نباتات')
                        ->modalDescription('يُطبَّق نفس التطبيق على جميع النباتات المحددة.')
                        ->schema(PlantInputApplicationForm::applicationFields(includeSharedImages: true))
                        ->fetchSelectedRecords(false)
                        ->action(function (Collection $records, array $data): void {
                            $plants = Plant::query()
                                ->whereIn('id', $records->all())
                                ->get();

                            DB::transaction(function () use ($plants, $data): void {
                                $beforeImages = self::normalizeImagePaths($data['shared_before_images'] ?? null);
                                $afterImages = self::normalizeImagePaths($data['shared_after_images'] ?? null);

                                foreach ($plants as $plant) {
                                    $plant->inputApplications()->create([
                                        'input_guide_id' => $data['input_guide_id'] ?? null,
                                        'applied_at' => $data['applied_at'],
                                        'phenomenon' => $data['phenomenon'] ?? null,
                                        'notes' => $data['notes'] ?? null,
                                        'before_images' => $beforeImages,
                                        'after_images' => $afterImages,
                                    ]);
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle('تم إضافة التطبيق للنباتات المحددة'),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @return array<int, string>|null
     */
    protected static function normalizeImagePaths(mixed $paths): ?array
    {
        if (! is_array($paths)) {
            $paths = filled($paths) ? [$paths] : null;
        }

        return filled($paths) ? array_values($paths) : null;
    }
}
