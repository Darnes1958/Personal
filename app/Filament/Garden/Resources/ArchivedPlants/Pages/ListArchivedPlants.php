<?php

namespace App\Filament\Garden\Resources\ArchivedPlants\Pages;

use App\Filament\Garden\Resources\ArchivedPlants\ArchivedPlantResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListArchivedPlants extends ListRecords
{
    protected static string $resource = ArchivedPlantResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    /**
     * SQL Server rejects duplicate ORDER BY columns. Filament's default
     * selected-records query can apply the default sort twice — skip sorting
     * and relationship aggregates here; bulk actions load plants separately.
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
