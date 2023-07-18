<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Messenger;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Queue\RequestLogEntry;
use LogAggregator\Application\Messenger\RequestLogEntryMessageHandler;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Assets\Assert\LogRequestAssert;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(RequestLogEntryMessageHandler::class)]
class RequestLogEntryMessageHandlerTest extends ApplicationTestCase
{
    private RequestLogEntryMessageHandler $handler;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = $this->getFromContainer(RequestLogEntryMessageHandler::class);
    }

    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testInsertLogRequest(RequestLogEntry $requestLogEntry): void
    {
        $this->handler->__invoke($requestLogEntry);

        $entities = $this->getEntities(RequestLog::class);
        $this->assertCount(1, $entities);

        LogRequestAssert::assertEntityMatchesMessage($requestLogEntry, $entities[0]);
    }
}
