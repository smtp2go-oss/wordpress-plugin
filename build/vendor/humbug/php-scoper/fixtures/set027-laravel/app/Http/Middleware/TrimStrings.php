<?php

namespace SMTP2GOWPPlugin\App\Http\Middleware;

use SMTP2GOWPPlugin\Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;
class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = ['password', 'password_confirmation'];
}
