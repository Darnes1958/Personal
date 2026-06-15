<?php

namespace App\Filament\Garden\Pages;

use App\Enums\Garden\Season;
use App\Filament\Garden\Resources\Plants\PlantResource;
use App\Models\PlantingGuide;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class WhatToPlant extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static ?string $navigationLabel = 'ماذا أزرع الآن؟';

    protected static ?string $title = 'ماذا أزرع الآن؟';

    protected static string|UnitEnum|null $navigationGroup = 'الدليل';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.garden.pages.what-to-plant';

    public ?int $filterMonth = null;

    public bool $todayOnly = true;

    /** @var array<int> */
    public array $guideIds = [];

    public function mount(): void
    {
        $this->filterMonth = (int) now()->format('n');
        $this->refreshGuides();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('todayOnly')
                    ->label('عرض ما يمكن زراعته اليوم فقط')
                    ->default(true)
                    ->live()
                    ->afterStateUpdated(function (): void {
                        $this->refreshGuides();
                        $this->resetTable();
                    }),
                Select::make('filterMonth')
                    ->label('الشهر')
                    ->options(collect(range(1, 12))->mapWithKeys(fn (int $month) => [
                        $month => $month.' — '.$this->monthLabel($month),
                    ]))
                    ->live()
                    ->afterStateUpdated(function (): void {
                        $this->refreshGuides();
                        $this->resetTable();
                    })
                    ->hidden(fn (): bool => $this->todayOnly),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PlantingGuide::query()
                    ->whereIn('id', $this->guideIds ?: [0])
                    ->orderBy('name')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('المحصول'),
                TextColumn::make('batch_label')
                    ->label('الدفعة')
                    ->placeholder('—'),
                TextColumn::make('category')
                    ->label('التصنيف')
                    ->badge(),
                TextColumn::make('planting_start')
                    ->label('موسم الزراعة')
                    ->formatStateUsing(fn (string $state, PlantingGuide $record) => $record->formatMonthDayRange(
                        $record->planting_start,
                        $record->planting_end,
                    )),
                TextColumn::make('harvest_start')
                    ->label('موسم الحصاد')
                    ->formatStateUsing(fn (?string $state, PlantingGuide $record) => $record->formatMonthDayRange(
                        $record->harvest_start,
                        $record->harvest_end,
                    ) ?? '—'),
                TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->limit(40)
                    ->placeholder('—'),
            ])
            ->recordActions([
                Action::make('registerPlanting')
                    ->label('تسجيل زراعة')
                    ->icon('heroicon-o-plus')
                    ->url(fn (PlantingGuide $record) => PlantResource::getUrl('create', [
                        'planting_guide_id' => $record->id,
                    ])),
            ])
            ->emptyStateHeading('لا توجد محاصيل في هذا الموعد')
            ->emptyStateDescription('أضف محاصيل في دليل الزراعة أو غيّر فترة الاستعلام.');
    }

    public function refreshGuides(): void
    {
        $guides = $this->todayOnly
            ? PlantingGuide::plantableOnDate()
            : PlantingGuide::plantableInMonth($this->filterMonth ?? (int) now()->format('n'));

        $this->guideIds = $guides->pluck('id')->all();
    }

    protected function monthLabel(int $month): string
    {
        return match ($month) {
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر',
        };
    }

    public function getCurrentSeasonLabel(): string
    {
        return Season::fromMonth((int) now()->format('n'))->getLabel();
    }
}
