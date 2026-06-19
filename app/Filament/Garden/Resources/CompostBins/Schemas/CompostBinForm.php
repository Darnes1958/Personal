<?php

namespace App\Filament\Garden\Resources\CompostBins\Schemas;

use App\Enums\Garden\CompostBinStage;
use App\Enums\Garden\CompostMaterialType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class CompostBinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('حوض ١ — شمال الحديقة'),
                Select::make('stage')
                    ->label('المرحلة الحالية')
                    ->options(CompostBinStage::class)
                    ->default(CompostBinStage::Empty)
                    ->required()
                    ->live()
                    ->native(false)
                    ->helperText(fn (Get $get): ?string => self::resolveStage($get('stage'))?->getDescription()),
                Select::make('material_type')
                    ->label('نوع المادة')
                    ->options(CompostMaterialType::class)
                    ->nullable()
                    ->native(false)
                    ->visible(fn (Get $get): bool => ! self::isEmptyStage($get('stage')))
                    ->required(fn (Get $get): bool => ! self::isEmptyStage($get('stage'))),
                DatePicker::make('stage_started_at')
                    ->label('بداية المرحلة')
                    ->default(now())
                    ->visible(fn (Get $get): bool => ! self::isEmptyStage($get('stage'))),
                Select::make('plant_location_id')
                    ->label('الموقع')
                    ->relationship(
                        name: 'plantLocation',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->active()->orderBy('name'),
                    )
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('اسم الموقع')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->nullable()
                    ->native(false),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    private static function resolveStage(mixed $value): ?CompostBinStage
    {
        if ($value instanceof CompostBinStage) {
            return $value;
        }

        if (is_string($value) || is_int($value)) {
            return CompostBinStage::tryFrom($value);
        }

        return null;
    }

    private static function isEmptyStage(mixed $value): bool
    {
        $stage = self::resolveStage($value);

        return $stage === null || $stage === CompostBinStage::Empty;
    }
}
