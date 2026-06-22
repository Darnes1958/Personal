<?php

namespace App\Filament\Garden\Resources\InputGuides\Schemas;

use App\Enums\Garden\InputGuideType;
use App\Enums\Garden\InputNature;
use App\Enums\Garden\InputSource;
use App\Enums\Garden\InputTimingType;
use App\Enums\Garden\PlantCategory;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class InputGuideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('العنصر أو المزيج')
                    ->schema([
                        TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('نترات البوتاس — أو مزيج مكافحة البياض'),
                        Select::make('type')
                            ->label('النوع')
                            ->options(InputGuideType::class)
                            ->required()
                            ->live()
                            ->native(false),
                        Select::make('nature')
                            ->label('الطبيعة')
                            ->options(InputNature::class)
                            ->required()
                            ->native(false),
                        Select::make('source')
                            ->label('المصدر')
                            ->options(InputSource::class)
                            ->required()
                            ->native(false),
                        Repeater::make('components')
                            ->label('مكونات المزيج')
                            ->schema([
                                TextInput::make('name')
                                    ->label('المكون')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('amount')
                                    ->label('الجرعة / الكمية')
                                    ->maxLength(255)
                                    ->placeholder('5 غ / لتر'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('إضافة مكون')
                            ->collapsible()
                            ->visible(fn (Get $get): bool => self::resolveType($get('type')) === InputGuideType::Combined)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('توقيت واستعمال')
                    ->schema([
                        Select::make('timing_type')
                            ->label('نوع التوقيت')
                            ->options(InputTimingType::class)
                            ->required()
                            ->native(false),
                        TextInput::make('timing_description')
                            ->label('وصف التوقيت / الظاهرة')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('45 يوم من الزراعة — أو عند ظهور بقع صفراء')
                            ->columnSpanFull(),
                        Select::make('target_categories')
                            ->label('يناسب تصنيفات')
                            ->options(PlantCategory::class)
                            ->multiple()
                            ->native(false)
                            ->columnSpanFull(),
                        Textarea::make('dosage_instructions')
                            ->label('تعليمات الجرعة والاستعمال')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    private static function resolveType(mixed $value): ?InputGuideType
    {
        if ($value instanceof InputGuideType) {
            return $value;
        }

        if (is_string($value) || is_int($value)) {
            return InputGuideType::tryFrom($value);
        }

        return null;
    }
}
