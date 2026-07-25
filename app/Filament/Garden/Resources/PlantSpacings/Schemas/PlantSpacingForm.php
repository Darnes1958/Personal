<?php

namespace App\Filament\Garden\Resources\PlantSpacings\Schemas;

use App\Models\PlantingGuide;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlantSpacingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المسافات')
                    ->schema([
                        Select::make('planting_guide_id')
                            ->label('المحصول (دليل الزراعة)')
                            ->relationship(
                                name: 'plantingGuide',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('name'),
                            )
                            ->getOptionLabelFromRecordUsing(fn (PlantingGuide $record): string => filled($record->batch_label)
                                ? "{$record->name} — {$record->batch_label}"
                                : $record->name)
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),
                        TextInput::make('row_spacing_cm')
                            ->label('المسافة بين الخطوط (سم)')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->suffix('سم'),
                        TextInput::make('plant_spacing_cm')
                            ->label('المسافة بين النباتات (سم)')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->suffix('سم'),
                        TextInput::make('depth_cm')
                            ->label('العمق (سم)')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->nullable()
                            ->suffix('سم'),
                    ])
                    ->columns(3),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
