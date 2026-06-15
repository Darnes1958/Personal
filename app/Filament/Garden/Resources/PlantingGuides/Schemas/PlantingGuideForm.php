<?php

namespace App\Filament\Garden\Resources\PlantingGuides\Schemas;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\Season;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class PlantingGuideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('المحصول')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم المحصول')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('batch_label')
                            ->label('تسمية الدفعة')
                            ->maxLength(255)
                            ->placeholder('دفعة أبريل'),
                        Select::make('category')
                            ->label('التصنيف')
                            ->options(PlantCategory::class)
                            ->required()
                            ->native(false),
                        Select::make('season')
                            ->label('الموسم')
                            ->options(Season::class)
                            ->nullable()
                            ->native(false),
                        TextInput::make('region')
                            ->label('المنطقة')
                            ->default('الساحل الليبي')
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('مواعيد الزراعة والحصاد')
                    ->description('استخدم صيغة شهر-يوم مثل 03-15 أي 15 مارس')
                    ->schema([
                        TextInput::make('planting_start')
                            ->label('بداية الزراعة')
                            ->required()
                            ->placeholder('03-01')
                            ->regex('/^(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/')
                            ->validationMessages([
                                'regex' => 'الصيغة المطلوبة: MM-DD مثل 03-15',
                            ]),
                        TextInput::make('planting_end')
                            ->label('نهاية الزراعة')
                            ->required()
                            ->placeholder('05-31')
                            ->regex('/^(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/')
                            ->validationMessages([
                                'regex' => 'الصيغة المطلوبة: MM-DD مثل 05-31',
                            ]),
                        TextInput::make('harvest_start')
                            ->label('بداية الحصاد')
                            ->placeholder('06-01')
                            ->regex('/^(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/')
                            ->nullable()
                            ->validationMessages([
                                'regex' => 'الصيغة المطلوبة: MM-DD مثل 06-01',
                            ]),
                        TextInput::make('harvest_end')
                            ->label('نهاية الحصاد')
                            ->placeholder('09-30')
                            ->regex('/^(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/')
                            ->nullable()
                            ->validationMessages([
                                'regex' => 'الصيغة المطلوبة: MM-DD مثل 09-30',
                            ]),
                    ])
                    ->columns(2),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
