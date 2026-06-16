<?php

namespace App\Filament\Garden\Resources\PlantEvents\Schemas;

use App\Enums\Garden\PlantEventType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                Repeater::make('images')
                    ->label('الصور')
                    ->relationship()
                    ->schema([
                        FileUpload::make('path')
                            ->label('الصورة')
                            ->image()
                            ->disk('public')
                            ->directory('garden/events')
                            ->required(),
                        TextInput::make('caption')
                            ->label('وصف الصورة')
                            ->maxLength(255),
                    ])
                    ->orderColumn('sort_order')
                    ->defaultItems(0)
                    ->addActionLabel('إضافة صورة')
                    ->collapsible()
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
            $fields[] = FileUpload::make('shared_image')
                ->label('صورة مشتركة (اختياري)')
                ->image()
                ->disk('public')
                ->directory('garden/events')
                ->columnSpanFull();
        }

        return $fields;
    }
}
