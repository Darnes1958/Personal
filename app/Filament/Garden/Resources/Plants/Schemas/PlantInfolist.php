<?php

namespace App\Filament\Garden\Resources\Plants\Schemas;

use App\Filament\Garden\Support\GardenFormats;
use App\Models\PlantEvent;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlantInfolist
{
    public static function configure(Schema $schema, bool $forArchive = false): Schema
    {
        $archiveSection = $forArchive
            ? [
                Section::make('بيانات الأرشيف')
                    ->schema([
                        TextEntry::make('archived_at')
                            ->label('تاريخ النقل للأرشيف')
                            ->dateTime(),
                        TextEntry::make('archive_reason')
                            ->label('سبب الإزالة')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]
            : [];

        $plantInfoSection = Section::make('معلومات النبات')
            ->schema([
                ImageEntry::make('card_image')
                    ->label('صور البطاقة')
                    ->disk('public')
                    ->circular()
                    ->stacked()
                    ->limit(5)
                    ->limitedRemainingText()
                    ->imageHeight(80),
                TextEntry::make('name')
                    ->label('الاسم'),
                TextEntry::make('plantVariety.name')
                    ->label('الصنف')
                    ->placeholder('—'),
                TextEntry::make('category')
                    ->label('التصنيف')
                    ->badge(),
                TextEntry::make('planted_at')
                    ->label('تاريخ الزراعة')
                    ->date(),
                TextEntry::make('plantLocation.name')
                    ->label('الموقع')
                    ->placeholder('—'),
                TextEntry::make('status')
                    ->label('الحالة')
                    ->badge(),
                TextEntry::make('plantingGuide.name')
                    ->label('دليل الزراعة')
                    ->placeholder('—'),
                TextEntry::make('notes')
                    ->label('ملاحظات')
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])
            ->columns(2);

        $eventsSection = Section::make('خط زمني الأحداث')
            ->schema([
                RepeatableEntry::make('events')
                    ->hiddenLabel()
                    ->placeholder('لا توجد أحداث')
                    ->table([
                        TableColumn::make('التاريخ')->width('9rem'),
                        TableColumn::make('أيام من الزراعة')->width('7rem'),
                        TableColumn::make('النوع')->width('8rem'),
                        TableColumn::make('الملاحظة'),
                        TableColumn::make('الصور')->width('9rem'),
                    ])
                    ->schema([
                        TextEntry::make('event_date')
                            ->hiddenLabel()
                            ->date(GardenFormats::TABLE_DATE),
                        TextEntry::make('days_since_planting')
                            ->hiddenLabel()
                            ->state(function (TextEntry $entry): ?string {
                                $event = $entry->getRecord();

                                if (! $event instanceof PlantEvent) {
                                    return null;
                                }

                                $days = $event->daysSincePlanting();

                                return $days === null ? null : $days.' يوم';
                            })
                            ->placeholder('—'),
                        TextEntry::make('type')
                            ->hiddenLabel()
                            ->badge(),
                        TextEntry::make('notes')
                            ->hiddenLabel()
                            ->placeholder('—'),
                        ImageEntry::make('images')
                            ->hiddenLabel()
                            ->disk('public')
                            ->circular()
                            ->stacked()
                            ->limit(3)
                            ->limitedRemainingText()
                            ->imageHeight(36),
                    ]),
            ])
            ->collapsible();

        return $schema
            ->columns(1)
            ->components([
                ...$archiveSection,
                Grid::make(['default' => 1, 'lg' => 12])
                    ->columnSpanFull()
                    ->schema([
                        $plantInfoSection->columnSpan(['default' => 1, 'lg' => 5]),
                        $eventsSection->columnSpan(['default' => 1, 'lg' => 7]),
                    ]),
            ]);
    }
}
