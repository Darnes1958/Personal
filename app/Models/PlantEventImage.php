<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantEventImage extends Model
{
    public function event(): BelongsTo
    {
        return $this->belongsTo(PlantEvent::class, 'plant_event_id');
    }
}
