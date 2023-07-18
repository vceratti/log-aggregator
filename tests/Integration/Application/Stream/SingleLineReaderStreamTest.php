<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Stream;

use Exception;
use LogAggregator\Application\Stream\SingleLineReaderStream;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Http\Message\StreamInterface;
use Tests\Assets\Stub\StubFileStream;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(SingleLineReaderStream::class)]
class SingleLineReaderStreamTest extends ApplicationTestCase
{
    public const TEST_FILE_PATH = __DIR__ . '/test.file';

    private StreamInterface $file;

    /** @throws Exception */
    public function setUp(): void
    {
        parent::setUp();
        $this->file = StubFileStream::newFileStream(self::TEST_FILE_PATH);
    }

    public function testGetContents(): void
    {
        $firstLine = 'sample data 1' . PHP_EOL;
        $secondLine = 'sample data 2' . PHP_EOL;

        $this->file->write($firstLine . $secondLine);

        $readOnlyStream = StubFileStream::getReadOnlyStream($this->file);
        $stream = new SingleLineReaderStream($readOnlyStream);

        $this->assertSame($firstLine, $stream->getContents());
        $this->assertSame($secondLine, $stream->getContents());
    }

    protected function tearDown(): void
    {
        StubFileStream::deleteFile($this->file);
        parent::tearDown();
    }
}
