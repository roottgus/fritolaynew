<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use Livewire\Livewire;
use App\Http\Livewire\NotificationBell;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Registra el Observer para el modelo User
        User::observe(UserObserver::class);

        // Registra el componente Livewire NotificationBell
        Livewire::component('notification-bell', NotificationBell::class);
    }
}