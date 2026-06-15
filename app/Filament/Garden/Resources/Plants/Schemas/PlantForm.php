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
                TextInput::make('variety')
                    ->label('الصنف')
                    ->maxLength(255)
                    ->placeholder('طماطم شيري'),
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
                TextInput::make('location')
                    ->label('الموقع')
                    ->maxLength(255)
                    ->placeholder('الحوض الشرقي'),
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
