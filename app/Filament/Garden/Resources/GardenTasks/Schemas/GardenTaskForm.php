<?php

namespace App\Filament\Garden\Resources\GardenTasks\Schemas;

use App\Enums\Garden\GardenTaskStatus;
use App\Enums\Garden\GardenTaskType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GardenTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('العنوان')
                    ->required()
                    ->maxLength(255),
                Select::make('plant_id')
                    ->label('النبات')
                    ->relationship('plant', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->native(false),
                Select::make('type')
                    ->label('النوع')
                    ->options(GardenTaskType::class)
                    ->required()
                    ->native(false),
                DatePicker::make('due_date')
                    ->label('الموعد')
                    ->required()
                    ->default(now()),
                Select::make('status')
                    ->label('الحالة')
                    ->options(GardenTaskStatus::class)
                    ->default(GardenTaskStatus::Pending)
                    ->required()
                    ->native(false),
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
