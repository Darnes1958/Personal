<?php

namespace App\Providers\Filament;

use App\Filament\Acc\Pages\AccDashboard;
use App\Livewire\widgets\State1;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AccPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandName('منظومة المحاسبة')
            ->sidebarFullyCollapsibleOnDesktop()
            ->breadcrumbs(false)
            ->maxContentWidth('Full')
            ->viteTheme('resources/css/filament/acc/theme.css')
            ->id('acc')
            ->path('acc')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Acc/Resources'), for: 'App\Filament\Acc\Resources')
            ->discoverPages(in: app_path('Filament/Acc/Pages'), for: 'App\Filament\Acc\Pages')
            ->pages([
              AccDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Acc/Widgets'), for: 'App\Filament\Acc\Widgets')
            ->widgets([
              State1::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
