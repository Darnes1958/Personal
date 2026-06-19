<?php

namespace App\Filament\Garden\Resources\Plants\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات النبات')
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
                    ->columns(2),
                Section::make('خط زمني الأحداث')
                    ->schema([
                        RepeatableEntry::make('events')
                            ->label('')
                            ->schema([
                                TextEntry::make('event_date')
                                    ->label('التاريخ')
                                    ->date(),
                                TextEntry::make('type')
                                    ->label('النوع')
                                    ->badge(),
                                TextEntry::make('notes')
                                    ->label('الملاحظة')
                                    ->placeholder('—'),
                                ImageEntry::make('images')
                                    ->label('الصور')
                                    ->disk('public')
                                    ->circular()
                                    ->stacked()
                                    ->limit(5)
                                    ->limitedRemainingText()
                                    ->imageHeight(80),
                            ])
                            ->columns(1),
                    ])
                    ->collapsible(),
            ]);
    }
}
