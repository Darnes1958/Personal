<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlantInputApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('التطبيق')
                    ->schema([
                        TextEntry::make('plant.name')
                            ->label('النبات'),
                        TextEntry::make('inputGuide.name')
                            ->label('من الدليل')
                            ->placeholder('—'),
                        TextEntry::make('inputGuide.type')
                            ->label('نوع الدليل')
                            ->badge()
                            ->placeholder('—'),
                        TextEntry::make('applied_at')
                            ->label('تاريخ التطبيق')
                            ->date(),
                        TextEntry::make('phenomenon')
                            ->label('الظاهرة / السبب')
                            ->placeholder('—'),
                        TextEntry::make('notes')
                            ->label('ملاحظات')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('قبل التطبيق')
                    ->schema([
                        ImageEntry::make('before_images')
                            ->label('')
                            ->disk('public')
                            ->stacked()
                            ->limit(6)
                            ->limitedRemainingText()
                            ->imageHeight(120),
                    ]),
                Section::make('بعد التطبيق')
                    ->schema([
                        ImageEntry::make('after_images')
                            ->label('')
                            ->disk('public')
                            ->stacked()
                            ->limit(6)
                            ->limitedRemainingText()
                            ->imageHeight(120),
                    ]),
            ]);
    }
}
