<?php

namespace App\Filament\Garden\Resources\Plants\Schemas;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use App\Models\PlantingGuide;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('الاسم')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('طماطم — دفعة أبريل'),
                Select::make('plant_variety_id')
                    ->label('الصنف')
                    ->relationship(
                        name: 'plantVariety',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->active()->orderBy('name'),
                    )
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('اسم الصنف')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])
                    ->native(false),
                Select::make('category')
                    ->label('التصنيف')
                    ->options(PlantCategory::class)
                    ->required()
                    ->native(false),
                Select::make('planting_guide_id')
                    ->label('من دليل الزراعة')
                    ->options(fn () => PlantingGuide::query()->active()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->nullable()
                    ->native(false),
                DatePicker::make('planted_at')
                    ->label('تاريخ الزراعة')
                    ->default(now()),
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
                    ->native(false),
                Select::make('status')
                    ->label('الحالة')
                    ->options(PlantStatus::class)
                    ->default(PlantStatus::Active)
                    ->required()
                    ->native(false),
                FileUpload::make('card_image')
                    ->label('صورة البطاقة')
                    ->image()
                    ->disk('public')
                    ->directory('garden/plants/cards')
                    ->imageEditor(),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
