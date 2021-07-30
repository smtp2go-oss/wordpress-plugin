<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\Isolated\Symfony\Component\Finder\Finder;
return ['finders' => [(new \SMTP2GOWPPlugin\Isolated\Symfony\Component\Finder\Finder())->files()->in(__DIR__ . \DIRECTORY_SEPARATOR . 'dir')]];
