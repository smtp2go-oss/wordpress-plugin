<?php

namespace SMTP2GOWPPlugin\App\Providers;

use SMTP2GOWPPlugin\Illuminate\Support\Facades\Gate;
use SMTP2GOWPPlugin\Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = ['SMTP2GOWPPlugin\\App\\Model' => 'SMTP2GOWPPlugin\\App\\Policies\\ModelPolicy'];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
