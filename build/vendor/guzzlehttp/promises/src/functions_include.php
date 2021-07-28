<?php

namespace SMTP2GOWpPlugin;

// Don't redefine the functions if included multiple times.
if (!\function_exists('SMTP2GOWpPlugin\\GuzzleHttp\\Promise\\promise_for')) {
    require __DIR__ . '/functions.php';
}
