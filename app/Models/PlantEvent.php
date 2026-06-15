<?php

namespace App\Models;

use App\Enums\Garden\PlantEventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlantEvent extends Model
{
    protected function casts(): array
    {
        return [
            'type' => PlantEventType::class,
            'event_date' => 'date',
        ];
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PlantEventImage::class)->orderBy('sort_order');
    }
}
