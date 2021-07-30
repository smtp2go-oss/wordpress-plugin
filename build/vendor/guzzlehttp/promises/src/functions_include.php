<?php

namespace SMTP2GOWPPlugin;

// Don't redefine the functions if included multiple times.
if (!\function_exists('SMTP2GOWPPlugin\\GuzzleHttp\\Promise\\promise_for')) {
    require __DIR__ . '/functions.php';
}
