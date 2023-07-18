<?php

declare(strict_types=1);

namespace LogAggregator\Application\Stream;

use LogAggregator\Application\Stream\Handler\FileContentsHandlerInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;

class FileStreamWorker
{
    private const SLEEP_TIME_MS = 10;
    private FileContentsHandlerInterface $handler;

    public function __construct(FileContentsHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /** @throws Throwable */
    public function process(StreamInterface $stream, float $timeout): void
    {
        $start = microtime(true);
        $end = $start + $timeout;
        do {
            if($stream->eof()) {
                usleep(self::SLEEP_TIME_MS * 1000);
                continue;
            }
            $this->handler->handle($stream->getContents());
        } while ($end > microtime(true));
    }
}
