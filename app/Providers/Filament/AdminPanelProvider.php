<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Register;
use App\Filament\Widgets\ReminderPembayaranWidget;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandLogo(asset('images/Logo Kos.png'))
            ->brandLogoHeight('3.5rem')
            ->brandName('Pojok Hunian')
            ->favicon(asset('images/Logo Kos.png'))
            ->default()
            ->id('admin')
            ->path('admin')
            ->darkMode(true)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->profile(EditProfile::class, isSimple: false)
            ->authGuard('web')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('17rem')
            ->registration(Register::class)
            ->colors([
                'primary' => Color::hex('#F5B731'), // ✅ tetap, amber brand PojokHunian
                'gray' => Color::Zinc,           // ← Slate diganti Zinc, lebih warm/netral
                'danger' => Color::Rose,           // ✅ tetap
                'warning' => Color::Orange,         // ← Amber diganti Orange, beda dari primary
                'success' => Color::Emerald,        // ✅ tetap
                'info' => Color::Sky,            // ← sedikit lebih lembut dari #3B82F6
            ])
            ->font('Plus Jakarta Sans', provider: GoogleFontProvider::class)
            ->navigationGroups([
                NavigationGroup::make('Manajemen Properti')
                    ->icon('heroicon-o-building-office-2')
                    ->collapsible(),
                NavigationGroup::make('Kelola Penghuni')
                    ->icon('heroicon-o-user-group')
                    ->collapsible(),
                NavigationGroup::make('Keuangan')
                    ->icon('heroicon-o-banknotes')
                    ->collapsible(),
                NavigationGroup::make('Kepegawaian')
                    ->icon('heroicon-o-briefcase')
                    ->collapsible(),
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')

            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                ReminderPembayaranWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('<script src="{{ asset("js/chart-darkmode.js") }}"></script>'),
            )
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn (): string => Blade::render('@livewire(\'properti-switcher\')'),
            );
    }
}
