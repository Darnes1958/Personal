<?php

namespace App\Filament\Garden\Resources\PlantSpacings\Schemas;

use App\Models\PlantingGuide;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PlantSpacingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المحصول')
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
                            ->native(false),
                    ]),
                Section::make('المسافة بين الخطوط')
                    ->schema([
                        TextInput::make('row_spacing_from_cm')
                            ->label('من')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->suffix('سم'),
                        TextInput::make('row_spacing_to_cm')
                            ->label('إلى')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->suffix('سم')
                            ->gte('row_spacing_from_cm'),
                    ])
                    ->columns(2),
                Section::make('المسافة بين النباتات')
                    ->schema([
                        TextInput::make('plant_spacing_from_cm')
                            ->label('من')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->suffix('سم'),
                        TextInput::make('plant_spacing_to_cm')
                            ->label('إلى')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->suffix('سم')
                            ->gte('plant_spacing_from_cm'),
                    ])
                    ->columns(2),
                Section::make('العمق')
                    ->description('اختياري')
                    ->schema([
                        TextInput::make('depth_from_cm')
                            ->label('من')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->nullable()
                            ->suffix('سم'),
                        TextInput::make('depth_to_cm')
                            ->label('إلى')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->nullable()
                            ->suffix('سم')
                            ->gte('depth_from_cm')
                            ->required(fn (Get $get): bool => filled($get('depth_from_cm'))),
                    ])
                    ->columns(2),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
