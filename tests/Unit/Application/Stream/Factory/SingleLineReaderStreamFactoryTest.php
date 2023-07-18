<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Stream\Factory;

use LogAggregator\Application\Stream\Factory\SingleLineReaderStreamFactory;
use LogAggregator\Application\Stream\SingleLineReaderStream;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Assets\Stub\StubFileStream;

#[CoversClass(SingleLineReaderStreamFactory::class)]
class SingleLineReaderStreamFactoryTest extends TestCase
{
    public const TEST_FILE_PATH = __DIR__ . '/test.file';

    public function testFactoryForValidFile(): void
    {
        $testFile = StubFileStream::newFileStream(self::TEST_FILE_PATH);
        $factory = new SingleLineReaderStreamFactory();

        try {
            $fileName = StubFileStream::getFileName($testFile);
            $this->assertInstanceOf(SingleLineReaderStream::class, $factory->makeStreamForFile($fileName));
        } finally {
            StubFileStream::deleteFile($testFile);
        }
    }

    public function testFailsForInvalidFile(): void
    {
        $this->expectException(RuntimeException::class);
        $factory = new SingleLineReaderStreamFactory();
        $factory->makeStreamForFile('invalid');
    }
}
