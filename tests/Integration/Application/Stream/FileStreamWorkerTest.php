<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Stream;

use Exception;
use LogAggregator\Application\Stream\FileStreamWorker;
use PHPUnit\Framework\Attributes\CoversClass;
use Psr\Http\Message\StreamInterface;
use Tests\Assets\Stub\StubFileContentHandler;
use Tests\Assets\Stub\StubFileStream;
use Tests\Assets\TestCase\ApplicationTestCase;
use Throwable;

#[CoversClass(FileStreamWorker::class)]
class FileStreamWorkerTest extends ApplicationTestCase
{
    public const TEST_FILE_PATH = __DIR__ . '/test.file';
    private StreamInterface $testFile;
    private FileStreamWorker $fileStreamWorker;
    private StubFileContentHandler $handler;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->testFile = StubFileStream::newFileStream(self::TEST_FILE_PATH);

        $this->handler = new StubFileContentHandler();
        $this->fileStreamWorker = new FileStreamWorker($this->handler);
    }

    /** @throws Throwable */
    public function testCanReadFromBeginning(): void
    {
        $firstLine = 'sample data 1' . PHP_EOL;
        $secondLine = 'sample data 2' . PHP_EOL;
        $sampleData = $firstLine . $secondLine;

        $this->testFile->write($sampleData);

        $stream = StubFileStream::getSingleLineReaderStream($this->testFile);

        $this->fileStreamWorker->process($stream, 0.01);

        $processedData = $this->handler->getLines();

        $this->assertCount(2, $processedData);
        $this->assertSame($firstLine, $processedData[0]);
        $this->assertSame($secondLine, $processedData[1]);
    }

    /** @throws Throwable */
    public function testCanStopAndContinue(): void
    {
        $firstLine = 'sample data 1' . PHP_EOL;
        $secondLine = 'sample data 2' . PHP_EOL;
        $sampleData = $firstLine . $secondLine;

        $this->testFile->write($sampleData);

        $stream = StubFileStream::getSingleLineReaderStream($this->testFile);

        $this->fileStreamWorker->process($stream, 0);

        $processedData = $this->handler->getLines();

        $this->assertCount(1, $processedData);
        $this->assertSame($firstLine, $processedData[0]);

        $this->fileStreamWorker->process($stream, 0);

        $processedData = $this->handler->getLines();

        $this->assertCount(2, $processedData);
        $this->assertSame($firstLine, $processedData[0]);
        $this->assertSame($secondLine, $processedData[1]);
    }
    protected function tearDown(): void
    {
        StubFileStream::deleteFile($this->testFile);
        parent::tearDown();
    }
}
