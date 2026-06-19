<?php

namespace App\Filament\Garden\Resources\CompostBins\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompostBinInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الحوض')
                    ->schema([
                        TextEntry::make('name')
                            ->label('الاسم'),
                        TextEntry::make('stage')
                            ->label('المرحلة')
                            ->badge(),
                        TextEntry::make('material_type')
                            ->label('نوع المادة')
                            ->badge()
                            ->placeholder('—'),
                        TextEntry::make('stage_started_at')
                            ->label('بداية المرحلة')
                            ->date()
                            ->placeholder('—'),
                        TextEntry::make('days_in_stage')
                            ->label('أيام في المرحلة')
                            ->state(fn ($record) => $record->daysInStage())
                            ->suffix(' يوم')
                            ->placeholder('—'),
                        TextEntry::make('plantLocation.name')
                            ->label('الموقع')
                            ->placeholder('—'),
                        TextEntry::make('notes')
                            ->label('ملاحظات')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('سجل الأحداث')
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
                            ])
                            ->columns(1),
                    ])
                    ->collapsible(),
            ]);
    }
}
