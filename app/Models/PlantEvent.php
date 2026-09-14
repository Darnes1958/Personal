<?php

namespace App\Models;

use App\Enums\Garden\PlantEventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantEvent extends Model
{
    protected function casts(): array
    {
        return [
            'type' => PlantEventType::class,
            'event_date' => 'date',
            'images' => 'array',
        ];
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function daysSincePlanting(): ?int
    {
        $plantedAt = $this->plant?->planted_at;

        if ($plantedAt === null || $this->event_date === null) {
            return null;
        }

        return (int) $plantedAt->copy()->startOfDay()->diffInDays(
            $this->event_date->copy()->startOfDay(),
            false,
        );
    }
}
