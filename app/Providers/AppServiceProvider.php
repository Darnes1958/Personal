<?php

namespace App\Providers;

use App\Models\Setting;
use Filament\Actions\CreateAction;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */    public $singletons = [

         LoginResponse::class => \App\Http\Responses\LoginResponse::class,
         LogoutResponse::class => \App\Http\Responses\LogoutResponse::class,

];

    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Pdf::default()

            ->withBrowsershot(function (Browsershot $shot) {
                $shot->noSandbox()
                    ->timeout(240)
                    ->setChromePath(Setting::first()->exePath);
            })
            ->margins(10, 10, 20, 10, );
        Model::unguard();
        CreateAction::configureUsing(function (CreateAction $comp): void {
            $comp->Label('إضافة');
        });
        DatePicker::configureUsing(function (DatePicker $datePicker): void {
            $datePicker->translateLabel();
        });
        Radio::configureUsing(function (Radio $radio): void {
             $radio->inline()->inlineLabel()->translateLabel();
        });
        TextInput::configureUsing(function (TextInput $input): void {
           $input->translateLabel();
        });
        TextColumn::configureUsing(function (TextColumn $column): void {
            $column->translateLabel();
        });
        IconColumn::configureUsing(function (IconColumn $column): void {
            $column->translateLabel();
        });
        Select::configureUsing(function (Select $column): void {
            $column->translateLabel();
        });
        TextEntry::configureUsing(function (TextEntry $entry): void {$entry->translateLabel();});


    }
}
