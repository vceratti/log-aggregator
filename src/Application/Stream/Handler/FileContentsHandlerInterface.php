<?php

declare(strict_types=1);

namespace LogAggregator\Application\Stream\Handler;

interface FileContentsHandlerInterface
{
    public function handle(string $line): void;
}
