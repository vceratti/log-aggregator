<?php

declare(strict_types=1);

namespace Tests\Assets\Stub;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
use LogAggregator\Application\Stream\SingleLineReaderStream;
use Psr\Http\Message\StreamInterface;

class StubFileStream
{
    public const WRITE_MODE = 'w+';
    public const READ_MODE = 'r';

    public static function newFileStream(string $path): StreamInterface
    {
        /** @var resource $resource */
        $resource = fopen($path . '.' . microtime(true), self::WRITE_MODE);
        ftruncate($resource, 0);

        return new Stream($resource);
    }

    public static function getReadOnlyStream(StreamInterface $stream): StreamInterface
    {
        $resource = Utils::tryFopen(self::getFileName($stream), self::READ_MODE);

        return Utils::streamFor($resource);
    }

    public static function getSingleLineReaderStream(StreamInterface $stream): StreamInterface
    {
        return new SingleLineReaderStream(self::getReadOnlyStream($stream));
    }

    public static function deleteFile(StreamInterface $stream): void
    {
        unlink(self::getFileName($stream));
    }

    public static function getFileName(StreamInterface $stream): string
    {
        /** @var string $path */
        $path = $stream->getMetadata('uri');

        return $path;
    }
}
