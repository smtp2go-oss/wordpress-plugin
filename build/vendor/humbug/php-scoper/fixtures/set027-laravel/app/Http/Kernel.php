<?php

namespace SMTP2GOWPPlugin\App\Http;

use SMTP2GOWPPlugin\Illuminate\Foundation\Http\Kernel as HttpKernel;
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [\SMTP2GOWPPlugin\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class, \SMTP2GOWPPlugin\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, \SMTP2GOWPPlugin\App\Http\Middleware\TrimStrings::class, \SMTP2GOWPPlugin\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, \SMTP2GOWPPlugin\App\Http\Middleware\TrustProxies::class];
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = ['web' => [
        \SMTP2GOWPPlugin\App\Http\Middleware\EncryptCookies::class,
        \SMTP2GOWPPlugin\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \SMTP2GOWPPlugin\Illuminate\Session\Middleware\StartSession::class,
        // \Illuminate\Session\Middleware\AuthenticateSession::class,
        \SMTP2GOWPPlugin\Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \SMTP2GOWPPlugin\App\Http\Middleware\VerifyCsrfToken::class,
        \SMTP2GOWPPlugin\Illuminate\Routing\Middleware\SubstituteBindings::class,
    ], 'api' => ['throttle:60,1', 'bindings']];
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = ['auth' => \SMTP2GOWPPlugin\Illuminate\Auth\Middleware\Authenticate::class, 'auth.basic' => \SMTP2GOWPPlugin\Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, 'bindings' => \SMTP2GOWPPlugin\Illuminate\Routing\Middleware\SubstituteBindings::class, 'cache.headers' => \SMTP2GOWPPlugin\Illuminate\Http\Middleware\SetCacheHeaders::class, 'can' => \SMTP2GOWPPlugin\Illuminate\Auth\Middleware\Authorize::class, 'guest' => \SMTP2GOWPPlugin\App\Http\Middleware\RedirectIfAuthenticated::class, 'signed' => \SMTP2GOWPPlugin\Illuminate\Routing\Middleware\ValidateSignature::class, 'throttle' => \SMTP2GOWPPlugin\Illuminate\Routing\Middleware\ThrottleRequests::class];
}
