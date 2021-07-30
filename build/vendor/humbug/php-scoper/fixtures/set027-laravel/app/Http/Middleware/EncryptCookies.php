<?php

namespace SMTP2GOWPPlugin\App\Http\Middleware;

use SMTP2GOWPPlugin\Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [];
}
