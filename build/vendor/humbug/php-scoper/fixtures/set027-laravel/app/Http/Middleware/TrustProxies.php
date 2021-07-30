<?php

namespace SMTP2GOWPPlugin\App\Http\Middleware;

use SMTP2GOWPPlugin\Illuminate\Http\Request;
use SMTP2GOWPPlugin\Fideloper\Proxy\TrustProxies as Middleware;
class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;
    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
