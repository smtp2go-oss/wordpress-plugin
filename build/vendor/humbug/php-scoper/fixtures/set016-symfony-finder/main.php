<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\Symfony\Component\Finder\Finder;
use SMTP2GOWPPlugin\Symfony\Component\Finder\SplFileInfo;
require_once __DIR__ . '/vendor/autoload.php';
$finder = Finder::create()->files()->in(__DIR__)->depth(0)->sortByName();
foreach ($finder as $fileInfo) {
    /** @var SplFileInfo $fileInfo */
    echo $fileInfo->getFilename() . \PHP_EOL;
}
