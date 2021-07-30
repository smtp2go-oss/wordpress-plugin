<?php

namespace SMTP2GOWPPlugin\App\Http\Middleware;

use SMTP2GOWPPlugin\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [];
}
