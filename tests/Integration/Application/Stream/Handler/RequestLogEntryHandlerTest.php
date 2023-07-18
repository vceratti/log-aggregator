<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Stream\Handler;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Application\Stream\Handler\RequestLogEntryHandler;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Assets\Assert\LogRequestAssert;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(RequestLogEntryHandler::class)]
class RequestLogEntryHandlerTest extends ApplicationTestCase
{
    private RequestLogEntryHandler $handler;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = $this->getFromContainer(RequestLogEntryHandler::class);
    }

    /** @throws InvalidMessageException*/
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testHandleMessage(RequestLogEntry $requestLogEntry, string $string): void
    {
        $this->handler->handle($string);

        $entities = $this->getEntities(RequestLog::class);
        $this->assertCount(1, $entities);
        LogRequestAssert::assertEntityMatchesMessage($requestLogEntry, $entities[0]);
    }
}
