<?php

namespace App\Models;

use App\Enums\Garden\CompostBinEventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompostBinEvent extends Model
{
    protected function casts(): array
    {
        return [
            'type' => CompostBinEventType::class,
            'event_date' => 'date',
        ];
    }

    public function compostBin(): BelongsTo
    {
        return $this->belongsTo(CompostBin::class);
    }
}
