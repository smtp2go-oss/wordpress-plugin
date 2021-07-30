<?php

namespace SMTP2GOWPPlugin;

use SMTP2GOWPPlugin\Symfony\Component\Finder\Finder;
return ['finders' => [(new Finder())->files()->in(__DIR__ . \DIRECTORY_SEPARATOR . 'dir')]];
