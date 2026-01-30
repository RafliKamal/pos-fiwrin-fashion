<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ForecastChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color; // Pastikan ini ter-import
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Dashboard; // Ini dashboard custom kita (benar)

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandLogo(fn() => view('filament.branding.logo'))
            ->login()
            ->darkMode(false)
            ->colors([
                'primary' => '#00695C',
                'secondary' => '#26A69A',
                'danger' => '#FF7043',
            ])
            ->sidebarCollapsibleOnDesktop()


            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')

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
            ])
            ->navigationItems([
                NavigationItem::make('Buka Kasir')
                    ->url(fn(): string => route('kasir.index'))
                    ->icon('heroicon-o-computer-desktop')
                    ->group('Penjualan')
                    ->sort(0)
                    ->visible(fn(): bool => auth()->check())
                    ->openUrlInNewTab(),
            ])
            ->renderHook(
                'panels::auth.login.form.before',
                fn() => view('filament.hooks.login-branding')
            )
            ->renderHook(
                'panels::head.end',
                fn() => view('filament.hooks.custom-styles')
            );
    }
}