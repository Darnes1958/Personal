<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantInputApplication extends Model
{
    protected function casts(): array
    {
        return [
            'applied_at' => 'date',
            'before_images' => 'array',
            'after_images' => 'array',
        ];
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function inputGuide(): BelongsTo
    {
        return $this->belongsTo(InputGuide::class);
    }
}
