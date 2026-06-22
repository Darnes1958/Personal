<?php

namespace App\Filament\Garden\Resources\PlantInputApplications\Schemas;

use App\Models\InputGuide;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlantInputApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('التطبيق')
                    ->schema([
                        Select::make('plant_id')
                            ->label('النبات')
                            ->relationship('plant', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        Select::make('input_guide_id')
                            ->label('من الدليل')
                            ->options(fn () => InputGuide::query()->active()->orderBy('name')->pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->native(false)
                            ->helperText('اختياري — يمكن التطبيق دون ربط بدليل'),
                        DatePicker::make('applied_at')
                            ->label('تاريخ التطبيق')
                            ->default(now())
                            ->required(),
                        TextInput::make('phenomenon')
                            ->label('الظاهرة / السبب')
                            ->maxLength(255)
                            ->placeholder('ذبول — بياض دقيقي — نقص حديد')
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('صور قبل وبعد')
                    ->description('صور حالة النبات قبل استخدام العنصر وبعده')
                    ->schema([
                        FileUpload::make('before_images')
                            ->label('قبل التطبيق')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->directory('garden/input-applications/before')
                            ->columnSpanFull(),
                        FileUpload::make('after_images')
                            ->label('بعد التطبيق')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->directory('garden/input-applications/after')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
