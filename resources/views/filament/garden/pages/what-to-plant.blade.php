<x-filament-panels::page>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ now()->translatedFormat('l j F Y') }}
        —
        موسم {{ $this->getCurrentSeasonLabel() }}
    </div>

    {{ $this->form }}

    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament-panels::page>
