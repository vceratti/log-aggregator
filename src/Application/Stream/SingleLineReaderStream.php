<?php

declare(strict_types=1);

namespace LogAggregator\Application\Stream;

use GuzzleHttp\Psr7\StreamDecoratorTrait;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;

class SingleLineReaderStream implements StreamInterface
{
    use StreamDecoratorTrait;

    private const MAX_BUFFER_SIZE = 1000;
    private StreamInterface $stream;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /** @SuppressWarnings(PHPMD.StaticAccess) */
    public function getContents(): string
    {
        return Utils::readLine($this->stream, self::MAX_BUFFER_SIZE);
    }
}
