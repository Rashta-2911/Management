<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (! class_exists(\Filament\Forms\Components\Section::class, false)) {
            class_alias(\Filament\Schemas\Components\Section::class, \Filament\Forms\Components\Section::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
