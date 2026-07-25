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

    public function formatRange(?int $from, ?int $to, string $unit = 'سم'): ?string
    {
        if (blank($from) && blank($to)) {
            return null;
        }

        if (filled($from) && filled($to) && $from === $to) {
            return "{$from} {$unit}";
        }

        if (filled($from) && filled($to)) {
            return "{$from} – {$to} {$unit}";
        }

        return filled($from) ? "من {$from} {$unit}" : "إلى {$to} {$unit}";
    }

    public function rowSpacingLabel(): ?string
    {
        return $this->formatRange($this->row_spacing_from_cm, $this->row_spacing_to_cm);
    }

    public function plantSpacingLabel(): ?string
    {
        return $this->formatRange($this->plant_spacing_from_cm, $this->plant_spacing_to_cm);
    }

    public function depthLabel(): ?string
    {
        return $this->formatRange($this->depth_from_cm, $this->depth_to_cm);
    }
}
