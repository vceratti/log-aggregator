<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Command;

use Exception;
use LogAggregator\Application\Command\LogStreamReaderCommand;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Tests\Assets\Assert\LogRequestAssert;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\Stub\StubFileStream;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(LogStreamReaderCommand::class)]
class LogStreamReaderCommandTest extends ApplicationTestCase
{
    public const TEST_FILE_PATH = __DIR__ . '/test.file';

    private LogStreamReaderCommand $command;
    private StreamInterface $file;

    /** @throws Exception */
    public function setUp(): void
    {
        parent::setUp();
        $this->command = $this->getFromContainer(LogStreamReaderCommand::class);
        $this->file = StubFileStream::newFileStream(self::TEST_FILE_PATH);
    }

    /**
     * @param RequestLogEntry[] $requestLogs
     * @throws ExceptionInterface
     */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validLogString')]
    public function testCommandSuccessfullyProcessLogfile(string $validLogString, array $requestLogs): void
    {
        $defaultArguments = [
            LogStreamReaderCommand::FILE_PATH_ARG => StubFileStream::getFileName($this->file),
            '--' . LogStreamReaderCommand::TIMEOUT_OPTION => 0.3
        ];

        $arguments = new ArrayInput($defaultArguments, $this->command->getDefinition());

        $this->file->write($validLogString);

        $result = $this->command->run($arguments, new ConsoleOutput());

        $this->assertSame(Command::SUCCESS, $result);
        $entities = $this->getEntities(RequestLog::class);
        $this->assertCount(count($requestLogs), $entities);

        $entity = current($entities);
        foreach ($requestLogs as $message) {
            $this->assertInstanceOf(RequestLog::class, $entity);
            LogRequestAssert::assertEntityMatchesMessage($message, $entity);
            $entity = next($entities);
        }
    }

    /** @throws ExceptionInterface */
    public function testCommandFailsWithoutFileArgument(): void
    {
        $this->expectException(RuntimeException::class);
        $this->command->run(new StringInput(''), new NullOutput());
    }

    /** @throws ExceptionInterface */
    public function testCommandHandleExceptionAndLogs(): void
    {
        $defaultArguments = [LogStreamReaderCommand::FILE_PATH_ARG => 'invalid'];

        $arguments = new ArrayInput($defaultArguments, $this->command->getDefinition());

        $output = new BufferedOutput();
        $this->command->run($arguments, $output);

        $this->assertMatchesRegularExpression('/RuntimeException. Unable to open.*/s', $output->fetch());
    }

    protected function tearDown(): void
    {
        StubFileStream::deleteFile($this->file);
        parent::tearDown();
    }
}
