<?php

namespace App\Filament\Garden\Support;

use App\Filament\Garden\Resources\Plants\PlantResource;
use App\Models\Plant;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlantArchiveActions
{
    public static function archiveAction(): Action
    {
        return Action::make('archive')
            ->label('نقل للأرشيف')
            ->icon('heroicon-o-archive-box')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('نقل النبات إلى الأرشيف؟')
            ->modalDescription('تُحفظ بيانات النبات وأحداثه وتطبيقاته كاملة في الأرشيف، ويمكن الرجوع إليها أو إعادة النبات إلى الحديقة لاحقاً. تُلغى المهام غير المكتملة المرتبطة به.')
            ->modalSubmitActionLabel('نقل للأرشيف')
            ->schema(self::reasonField())
            ->action(function (Plant $record, array $data): void {
                $record->archive($data['archive_reason'] ?? null);
            })
            ->successRedirectUrl(fn () => PlantResource::getUrl('index'))
            ->successNotificationTitle('تم نقل النبات إلى الأرشيف');
    }

    public static function archiveBulkAction(): BulkAction
    {
        return BulkAction::make('archive')
            ->label('نقل للأرشيف')
            ->icon('heroicon-o-archive-box')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('نقل النباتات المحددة إلى الأرشيف')
            ->modalDescription('تُنقل النباتات مع أحداثها وتطبيقاتها إلى الأرشيف، وتُلغى مهامها غير المكتملة. يمكن استعادتها لاحقاً.')
            ->modalSubmitActionLabel('نقل للأرشيف')
            ->schema(self::reasonField())
            ->fetchSelectedRecords(false)
            ->action(function (Collection $records, array $data): void {
                $plants = Plant::query()
                    ->whereIn('id', $records->all())
                    ->get();

                DB::transaction(function () use ($plants, $data): void {
                    foreach ($plants as $plant) {
                        $plant->archive($data['archive_reason'] ?? null);
                    }
                });
            })
            ->deselectRecordsAfterCompletion()
            ->successNotificationTitle('تم نقل النباتات المحددة إلى الأرشيف');
    }

    public static function restoreAction(): Action
    {
        return Action::make('restore')
            ->label('إعادة إلى الحديقة')
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('إعادة النبات إلى الحديقة؟')
            ->modalDescription('يعود النبات إلى قائمة النباتات القائمة مع كل أحداثه وتطبيقاته.')
            ->modalSubmitActionLabel('إعادة')
            ->action(function (Plant $record): void {
                $record->restoreFromArchive();
            })
            ->successRedirectUrl(fn (Plant $record) => PlantResource::getUrl('view', ['record' => $record]))
            ->successNotificationTitle('تمت إعادة النبات إلى الحديقة');
    }

    public static function restoreBulkAction(): BulkAction
    {
        return BulkAction::make('restore')
            ->label('إعادة إلى الحديقة')
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('إعادة النباتات المحددة إلى الحديقة')
            ->modalSubmitActionLabel('إعادة')
            ->fetchSelectedRecords(false)
            ->action(function (Collection $records): void {
                $plants = Plant::query()
                    ->onlyArchived()
                    ->whereIn('id', $records->all())
                    ->get();

                DB::transaction(function () use ($plants): void {
                    foreach ($plants as $plant) {
                        $plant->restoreFromArchive();
                    }
                });
            })
            ->deselectRecordsAfterCompletion()
            ->successNotificationTitle('تمت إعادة النباتات المحددة إلى الحديقة');
    }

    /**
     * @return array<int, Textarea>
     */
    protected static function reasonField(): array
    {
        return [
            Textarea::make('archive_reason')
                ->label('سبب الإزالة')
                ->rows(2)
                ->maxLength(1000)
                ->placeholder('مثال: انتهى الموسم، مات النبات، نُقل من الموقع…'),
        ];
    }
}
