<?php

namespace App\Models;

use App\Enums\Garden\GardenTaskStatus;
use App\Enums\Garden\GardenTaskType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenTask extends Model
{
    protected function casts(): array
    {
        return [
            'type' => GardenTaskType::class,
            'status' => GardenTaskStatus::class,
            'due_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (GardenTask $task): void {
            if ($task->status === GardenTaskStatus::Completed && ! $task->completed_at) {
                $task->completed_at = now();
            }

            if ($task->status !== GardenTaskStatus::Completed) {
                $task->completed_at = null;
            }

            if ($task->status === GardenTaskStatus::Pending && $task->due_date?->isPast()) {
                $task->status = GardenTaskStatus::Overdue;
            }
        });
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function markCompleted(): void
    {
        $this->update([
            'status' => GardenTaskStatus::Completed,
            'completed_at' => now(),
        ]);
    }

    public static function refreshOverdue(): void
    {
        static::query()
            ->where('status', GardenTaskStatus::Pending)
            ->whereDate('due_date', '<', now()->toDateString())
            ->update(['status' => GardenTaskStatus::Overdue->value]);
    }
}
