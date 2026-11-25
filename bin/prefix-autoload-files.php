<?php

/**
 * Rewrites the Composer "files" autoload identifiers in the scoped build.
 *
 * Composer skips any autoload file whose identifier (md5 of package name + path) is already in
 * $GLOBALS['__composer_autoload_files']. Scoping does not change that identifier, so if another
 * plugin bundles the same package (e.g. symfony/deprecation-contracts) and loads first, our
 * scoped copy is never included. Prefixing the identifiers makes them unique to this plugin.
 */

if (PHP_SAPI !== 'cli') {
    exit;
}

$composerDir = dirname(__DIR__) . '/build/vendor/composer';

foreach (['autoload_files.php', 'autoload_static.php'] as $file) {
    $path = $composerDir . '/' . $file;

    if (!is_file($path)) {
        continue;
    }

    $contents = file_get_contents($path);

    $updated = preg_replace_callback(
        "/'([0-9a-f]{32})' =>/",
        function ($matches) {
            return "'" . md5('SMTP2GOWPPlugin' . $matches[1]) . "' =>";
        },
        $contents,
        -1,
        $count
    );

    file_put_contents($path, $updated);

    echo "Prefixed {$count} autoload file identifier(s) in {$file}" . PHP_EOL;
}
