<?php

namespace App\Providers;

use App\Filament\Acc\Pages\InpKyde;
use App\Models\OurCompany;
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
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
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
        $this->ensureUploadDirectories();

        Pdf::default()

            ->withBrowsershot(function (Browsershot $shot) {
                $shot->noSandbox()
                    ->timeout(240)
                    ->setChromePath(Setting::first()->exePath);
            })
            ->margins(10, 10, 20, 10, );
        Model::unguard();

        Table::configureUsing(function (Table $table) {
            $table->defaultNumberLocale('nl')->emptyStateHeading('لا توجد بيانات');
        });
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

        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_AFTER,
            fn (): View => view('avatar',['compImage'=>OurCompany::where('company',Auth::user()->company)->first()->CompanyImg]),
        );
        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): string => Blade::render('@livewire(\'top-bar\')'),
        );
        FilamentAsset::register([
            Js::make('example-external-script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js'),
            Js::make('custom-script', __DIR__.'/../../resources/js/custom.js'),
        ]);
        FilamentView::registerRenderHook(
            'panels::page.end',
            fn (): View => view('analytics'),
            scopes: [
                InpKyde::class,
                ],
        );


    }

    protected function ensureUploadDirectories(): void
    {
        $directories = [
            storage_path('app/private/livewire-tmp'),
            storage_path('app/public/garden/plants/cards'),
            storage_path('app/public/garden/events'),
        ];

        foreach ($directories as $directory) {
            if (! File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
        }

        if (Storage::disk('local')->directoryMissing('livewire-tmp')) {
            Storage::disk('local')->makeDirectory('livewire-tmp');
        }
    }
}
