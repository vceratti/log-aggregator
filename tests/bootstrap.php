<?php

declare(strict_types=1);

use LogAggregator\Application\Symfony\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$_ENV['KERNEL_CLASS'] = Kernel::class;

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
