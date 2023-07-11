<?php

declare(strict_types=1);

use LogAggregator\Application\Symfony\Kernel;
use Tests\Shared\TestDatabase;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$_ENV['KERNEL_CLASS'] = Kernel::class;

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

$kernel = new Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$kernel->boot();

/** @var TestDatabase $testDatabase */
$testDatabase = $kernel->getContainer()->get(TestDatabase::class);
$testDatabase->healthCheck();
$testDatabase->migrate();
