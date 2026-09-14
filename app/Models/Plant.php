<?php

namespace App\Models;

use App\Enums\Garden\GardenTaskStatus;
use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use App\Models\Scopes\NotArchivedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Plant extends Model
{
    protected function casts(): array
    {
        return [
            'category' => PlantCategory::class,
            'status' => PlantStatus::class,
            'planted_at' => 'date',
            'archived_at' => 'datetime',
            'card_image' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new NotArchivedScope);
    }

    public function plantingGuide(): BelongsTo
    {
        return $this->belongsTo(PlantingGuide::class);
    }

    public function plantVariety(): BelongsTo
    {
        return $this->belongsTo(PlantVariety::class);
    }

    public function plantLocation(): BelongsTo
    {
        return $this->belongsTo(PlantLocation::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(PlantEvent::class)->orderByDesc('event_date');
    }

    public function loadForView(): static
    {
        $this->load(['events', 'plantingGuide']);
        $this->events->each(fn (PlantEvent $event) => $event->setRelation('plant', $this));

        return $this;
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(GardenTask::class);
    }

    public function inputApplications(): HasMany
    {
        return $this->hasMany(PlantInputApplication::class)->orderByDesc('applied_at');
    }

    public function scopeWithArchived(Builder $query): Builder
    {
        return $query->withoutGlobalScope(NotArchivedScope::class);
    }

    public function scopeOnlyArchived(Builder $query): Builder
    {
        return $query
            ->withoutGlobalScope(NotArchivedScope::class)
            ->whereNotNull($query->getModel()->getTable().'.archived_at');
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    public function archive(?string $reason = null): void
    {
        if ($this->isArchived()) {
            return;
        }

        DB::transaction(function () use ($reason): void {
            $this->forceFill([
                'archived_at' => now(),
                'archive_reason' => filled($reason) ? $reason : null,
            ])->save();

            $this->tasks()
                ->whereIn('status', [
                    GardenTaskStatus::Pending->value,
                    GardenTaskStatus::Overdue->value,
                ])
                ->update(['status' => GardenTaskStatus::Cancelled->value]);
        });
    }

    public function restoreFromArchive(): void
    {
        if (! $this->isArchived()) {
            return;
        }

        $this->forceFill([
            'archived_at' => null,
            'archive_reason' => null,
        ])->save();
    }
}
