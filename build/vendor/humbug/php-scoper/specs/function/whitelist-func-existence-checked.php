<?php

declare (strict_types=1);
namespace SMTP2GOWPPlugin;

/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
return ['meta' => [
    'title' => 'Whitelisting functions which are never declared but for which the existence is checked',
    // Default values. If not specified will be the one used
    'prefix' => 'Humbug',
    'whitelist' => [],
    'whitelist-global-constants' => \false,
    'whitelist-global-classes' => \false,
    'whitelist-global-functions' => \false,
    'registered-classes' => [],
    'registered-functions' => [],
], 'Non whitelisted global function call' => <<<'PHP'
<?php

function_exists('main');
----
<?php

namespace Humbug;

\function_exists('Humbug\\main');

PHP
, 'Whitelisted global function call' => ['whitelist' => ['main'], 'registered-functions' => [['main', 'SMTP2GOWPPlugin\\Humbug\\main']], 'payload' => <<<'PHP'
<?php

function_exists('main');
----
<?php

namespace Humbug;

\function_exists('Humbug\\main');

PHP
], 'Global function call with whitelisted global functions' => ['whitelist-global-functions' => \true, 'registered-functions' => [['main', 'SMTP2GOWPPlugin\\Humbug\\main']], 'payload' => <<<'PHP'
<?php

function_exists('main');
----
<?php

namespace Humbug;

\function_exists('Humbug\\main');

PHP
], 'Global function call with non-whitelisted global functions' => <<<'PHP'
<?php

function_exists('main');
----
<?php

namespace Humbug;

\function_exists('Humbug\\main');

PHP
, 'Whitelisted namespaced function call' => ['whitelist' => ['SMTP2GOWPPlugin\\Acme\\main'], 'registered-functions' => [['SMTP2GOWPPlugin\\Acme\\main', 'SMTP2GOWPPlugin\\Humbug\\Acme\\main']], 'payload' => <<<'PHP'
<?php

namespace Acme;

function_exists('Acme\main');
----
<?php

namespace Humbug\Acme;

\function_exists('Humbug\\Acme\\main');

PHP
]];