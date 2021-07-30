<?php

namespace SMTP2GOWPPlugin\App\Providers;

use SMTP2GOWPPlugin\Illuminate\Support\Facades\Event;
use SMTP2GOWPPlugin\Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = ['SMTP2GOWPPlugin\\App\\Events\\Event' => ['SMTP2GOWPPlugin\\App\\Listeners\\EventListener']];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
