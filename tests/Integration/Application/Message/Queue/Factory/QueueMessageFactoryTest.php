<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Message\Queue\Factory;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Queue\Factory\QueueMessageFactory;
use LogAggregator\Application\Message\Queue\RequestLogEntry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(QueueMessageFactory::class)]
class QueueMessageFactoryTest extends ApplicationTestCase
{
    private QueueMessageFactory $factory;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = $this->getFromContainer(QueueMessageFactory::class);
    }
    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testMakeMessageFromString(RequestLogEntry $requestLogEntry, string $inputString): void
    {
        $message = $this->factory->makeMessageFromString(RequestLogEntry::class, $inputString);
        $this->assertInstanceOf(RequestLogEntry::class, $message);
        $this->assertSame((array)$requestLogEntry, (array)$message);
    }

    /** @throws InvalidMessageException */
    public function testExceptionOnInvalidString(): void
    {
        $this->expectException(InvalidMessageException::class);
        $this->factory->makeMessageFromString(RequestLogEntry::class, 'invalid');
    }
}
