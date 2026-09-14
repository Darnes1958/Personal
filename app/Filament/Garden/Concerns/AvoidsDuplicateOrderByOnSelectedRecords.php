<?php

namespace App\Filament\Garden\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait AvoidsDuplicateOrderByOnSelectedRecords
{
    /**
     * SQL Server rejects duplicate ORDER BY columns. Filament's default
     * selected-records query can apply the default sort twice.
     */
    public function getSelectedTableRecordsQuery(bool $shouldFetchSelectedRecords = true, ?int $chunkSize = null): Builder
    {
        $table = $this->getTable();

        if ($this->isTrackingDeselectedTableRecords) {
            $query = $table->getQuery()->whereKeyNot($this->deselectedTableRecords);
        } else {
            $query = $table->getQuery()->whereKey($this->selectedTableRecords);
        }

        if ($shouldFetchSelectedRecords) {
            foreach ($table->getColumns() as $column) {
                $column->applyEagerLoading($query);
            }
        }

        return $query;
    }
}
