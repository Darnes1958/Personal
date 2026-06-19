<?php

namespace App\Filament\Garden\Resources\PlantEvents\Schemas;

use App\Enums\Garden\PlantEventType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PlantEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('plant_id')
                    ->label('النبات')
                    ->relationship('plant', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
                ...self::eventFields(),
                FileUpload::make('images')
                    ->label('الصور')
                    ->image()
                    ->multiple()
                    ->reorderable()
                    ->disk('public')
                    ->directory('garden/events')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function eventFields(bool $includeSharedImage = false): array
    {
        $fields = [
            Select::make('type')
                ->label('نوع الحدث')
                ->options(PlantEventType::class)
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
        ];

        if ($includeSharedImage) {
            $fields[] = FileUpload::make('shared_images')
                ->label('صور مشتركة (اختياري)')
                ->image()
                ->multiple()
                ->reorderable()
                ->disk('public')
                ->directory('garden/events')
                ->columnSpanFull();
        }

        return $fields;
    }
}
