<?php

namespace App\Providers;

use Filament\Forms\Components\Section;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (! class_exists(Section::class, false)) {
            class_alias(\Filament\Schemas\Components\Section::class, Section::class);
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
