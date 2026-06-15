<div class="flex items-center gap-4">
    @if (auth()->user()->is_programmer)
        <x-filament::input.wrapper>
            <x-filament::input.select wire:model="hisSystem" wire:change="hisSystemSelected">
                @foreach ($hisSystemOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>

        <x-filament::input.wrapper>
            <x-filament::input.select wire:model="status" wire:change="optionSelected">
                <option value="{{ $name }}">{{ $name }}</option>
                @foreach ($company as $item)
                    <option value="{{ $item->Company }}">{{ $item->Company }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    @endif
</div>
