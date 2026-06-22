<?php

namespace App\Filament\Garden\Resources\InputGuides\Tables;

use App\Enums\Garden\InputGuideType;
use App\Enums\Garden\InputNature;
use App\Enums\Garden\InputSource;
use App\Enums\Garden\InputTimingType;
use App\Models\InputGuide;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class InputGuidesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),
                TextColumn::make('nature')
                    ->label('الطبيعة')
                    ->badge(),
                TextColumn::make('source')
                    ->label('المصدر')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('timing_type')
                    ->label('التوقيت')
                    ->badge(),
                TextColumn::make('timing_description')
                    ->label('الوصف')
                    ->limit(40)
                    ->tooltip(fn (InputGuide $record): ?string => $record->timing_description),
                TextColumn::make('target_category_labels')
                    ->label('التصنيفات')
                    ->state(fn (InputGuide $record): string => implode('، ', $record->targetCategoryLabels()) ?: '—')
                    ->toggleable(),
                TextColumn::make('applications_count')
                    ->label('التطبيقات')
                    ->counts('applications'),
                IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('type')
                    ->label('النوع')
                    ->options(InputGuideType::class),
                SelectFilter::make('nature')
                    ->label('الطبيعة')
                    ->options(InputNature::class),
                SelectFilter::make('source')
                    ->label('المصدر')
                    ->options(InputSource::class),
                SelectFilter::make('timing_type')
                    ->label('نوع التوقيت')
                    ->options(InputTimingType::class),
                TernaryFilter::make('is_active')
                    ->label('نشط'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
