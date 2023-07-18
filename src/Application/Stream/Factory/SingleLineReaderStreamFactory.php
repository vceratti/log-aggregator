<?php

declare(strict_types=1);

namespace LogAggregator\Application\Stream\Factory;

use GuzzleHttp\Psr7\Utils;
use LogAggregator\Application\Stream\SingleLineReaderStream;

class SingleLineReaderStreamFactory
{
    private const FILE_MODE = 'r';

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    public function makeStreamForFile(string $filename): SingleLineReaderStream
    {
        $resource = Utils::tryFopen($filename, self::FILE_MODE);
        $stream = Utils::streamFor($resource);

        return new SingleLineReaderStream($stream);

    }
}
