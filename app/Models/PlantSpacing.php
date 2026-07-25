<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantSpacing extends Model
{
    public function plantingGuide(): BelongsTo
    {
        return $this->belongsTo(PlantingGuide::class);
    }
}
