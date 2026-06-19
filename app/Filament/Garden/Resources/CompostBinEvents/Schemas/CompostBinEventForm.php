<?php

namespace App\Filament\Garden\Resources\CompostBinEvents\Schemas;

use App\Enums\Garden\CompostBinEventType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CompostBinEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('compost_bin_id')
                    ->label('الحوض')
                    ->relationship('compostBin', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
                Select::make('type')
                    ->label('نوع الحدث')
                    ->options(CompostBinEventType::class)
                    ->default(CompostBinEventType::Turning)
                    ->required()
                    ->native(false),
                DatePicker::make('event_date')
                    ->label('التاريخ')
                    ->default(now())
                    ->required(),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
