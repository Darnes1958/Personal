<?php

namespace App\Models;

use App\Enums\Garden\CompostBinStage;
use App\Enums\Garden\CompostMaterialType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompostBin extends Model
{
    protected function casts(): array
    {
        return [
            'material_type' => CompostMaterialType::class,
            'stage' => CompostBinStage::class,
            'stage_started_at' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (CompostBin $bin): void {
            if ($bin->isDirty('stage')) {
                $stage = $bin->stage;

                if ($stage === CompostBinStage::Empty) {
                    $bin->material_type = null;
                    $bin->stage_started_at = null;
                } elseif ($bin->stage_started_at === null || ! $bin->isDirty('stage_started_at')) {
                    $bin->stage_started_at = now();
                }
            }
        });
    }

    public function plantLocation(): BelongsTo
    {
        return $this->belongsTo(PlantLocation::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(CompostBinEvent::class);
    }

    public function daysInStage(): ?int
    {
        if ($this->stage === CompostBinStage::Empty || $this->stage_started_at === null) {
            return null;
        }

        return (int) $this->stage_started_at->diffInDays(now());
    }
}
