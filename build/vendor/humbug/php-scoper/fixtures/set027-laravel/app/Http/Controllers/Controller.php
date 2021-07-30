<?php

namespace SMTP2GOWPPlugin\App\Http\Controllers;

use SMTP2GOWPPlugin\Illuminate\Foundation\Bus\DispatchesJobs;
use SMTP2GOWPPlugin\Illuminate\Routing\Controller as BaseController;
use SMTP2GOWPPlugin\Illuminate\Foundation\Validation\ValidatesRequests;
use SMTP2GOWPPlugin\Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
