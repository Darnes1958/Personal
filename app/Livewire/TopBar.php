<?php

namespace App\Livewire;

use App\Enums\hisSystem;
use App\Models\OurCompany;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TopBar extends Component
{
    public $status;

    public $name;

    public $hisSystem;

    public function optionSelected(): mixed
    {
        User::find(Auth::id())->update(['company' => $this->status]);
        $this->name = Auth::user()->company;

        return redirect(request()->header('Referer'));
    }

    public function hisSystemSelected(): mixed
    {
        User::find(Auth::id())->update(['hisSystem' => $this->hisSystem]);

        return redirect(match ($this->hisSystem) {
            hisSystem::Card->value => Filament::getPanel('card')->getPath(),
            hisSystem::Personal->value => Filament::getPanel('admin')->getPath(),
            hisSystem::Sell->value => Filament::getPanel('sell')->getPath(),
            hisSystem::Acc->value => Filament::getPanel('acc')->getPath(),
            hisSystem::Garden->value => Filament::getPanel('garden')->getPath(),
            default => '/',
        });
    }

    public function mount(): void
    {
        $this->name = Auth::user()->company;
        $this->hisSystem = Auth::user()->hisSystem->value;
    }

    public function render()
    {
        $company = OurCompany::query()->get();

        $hisSystemOptions = collect(hisSystem::cases())
            ->mapWithKeys(fn (hisSystem $system) => [$system->value => $system->getLabel()]);

        return view('livewire.top-bar', [
            'company' => $company,
            'name' => $this->name,
            'hisSystemOptions' => $hisSystemOptions,
        ]);
    }
}
