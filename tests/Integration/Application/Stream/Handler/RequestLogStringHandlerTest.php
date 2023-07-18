<?php

declare(strict_types=1);

namespace Tests\Integration\Application\Stream\Handler;

use Exception;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\Queue\RequestLogEntry;
use LogAggregator\Application\Stream\Handler\RequestLogStringHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;
use Tests\Assets\TestCase\ApplicationTestCase;

#[CoversClass(RequestLogStringHandler::class)]
class RequestLogStringHandlerTest extends ApplicationTestCase
{
    private RequestLogStringHandler $handler;

    /** @throws Exception */
    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = $this->getFromContainer(RequestLogStringHandler::class);
    }

    /** @throws InvalidMessageException*/
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testHandleMessage(RequestLogEntry $requestLogEntry, string $string): void
    {
        $this->handler->handle($string);

        $messages = $this->getAllMessages();
        $this->assertCount(1, $messages);
        $this->assertSame((array)$requestLogEntry, (array)$messages[0]->getMessage());
    }
}
