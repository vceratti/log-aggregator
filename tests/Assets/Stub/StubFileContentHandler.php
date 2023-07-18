<?php

declare(strict_types=1);

namespace Tests\Assets\Stub;

use LogAggregator\Application\Stream\Handler\FileContentsHandlerInterface;

class StubFileContentHandler implements FileContentsHandlerInterface
{
    /** @var string[] */
    private array $lines = [];

    public function handle(string $line): void
    {
        if (!empty($line)) {
            $this->lines[] = $line;
        }
    }

    /** @return  string[] */
    public function getLines(): array
    {
        return $this->lines;
    }
}
