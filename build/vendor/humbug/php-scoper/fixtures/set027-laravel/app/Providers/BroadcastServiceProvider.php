<?php

namespace SMTP2GOWPPlugin\App\Providers;

use SMTP2GOWPPlugin\Illuminate\Support\ServiceProvider;
use SMTP2GOWPPlugin\Illuminate\Support\Facades\Broadcast;
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();
        require base_path('routes/channels.php');
    }
}
