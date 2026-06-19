<?php

namespace App\Models;

use App\Enums\Garden\PlantCategory;
use App\Enums\Garden\PlantStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    protected function casts(): array
    {
        return [
            'category' => PlantCategory::class,
            'status' => PlantStatus::class,
            'planted_at' => 'date',
            'card_image' => 'array',
        ];
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

    public function tasks(): HasMany
    {
        return $this->hasMany(GardenTask::class);
    }
}
