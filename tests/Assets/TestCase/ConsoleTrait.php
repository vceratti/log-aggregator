<?php

declare(strict_types=1);

namespace Tests\Assets\TestCase;

use Exception;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

trait ConsoleTrait
{
    /** @throws Exception */
    protected function consoleRun(string $command): int
    {
        $input = new StringInput($command);
        $output = new NullOutput();

        return self::console()->run($input, $output);
    }

    protected function console(): Application
    {
        $console = new Application(self::$kernel);
        $console->setCatchExceptions(true);
        $console->setAutoExit(false);

        return $console;
    }
}
