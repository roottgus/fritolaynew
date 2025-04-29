<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // DEBE incluir auth para que el callback reciba $user
        Broadcast::routes([
            'middleware' => ['web', 'auth'],
        ]);

        require base_path('routes/channels.php');
    }
}
