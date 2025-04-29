<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar el tema AdminLTE como CSS de Filament
        FilamentAsset::register([
            Css::make(
                'adminlte-theme',
                resource_path('css/filament/admin/theme.css')
            ),
        ]);

        // Registrar script principal de la aplicación (opcional)
        FilamentAsset::register([
            Js::make(
                'app-scripts',
                resource_path('js/app.js')
            ),
        ]);
    }
}
