<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Message;

use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;

#[CoversClass(RequestLogEntry::class)]
class RequestLogEntryTest extends TestCase
{
    /** @throws InvalidMessageException */
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validLogEntries')]
    public function testMessageFromLogEntry(
        string $serviceName,
        string $dateTime,
        string $query,
        int    $statusCode
    ): void {

        $input = RequestLogEntryDataProvider::makeLogString([$serviceName, $dateTime, $query, $statusCode]);
        $message = new RequestLogEntry($input);

        $this->assertSame($serviceName, $message->getServiceName());
        $this->assertSame($query, $message->getQuery());
        $this->assertSame($statusCode, $message->getStatusCode());
        $this->assertSame($dateTime, $message->getDateTime());
    }

    public function testExceptionOnInvalidMessage(): void
    {
        $this->expectException(InvalidMessageException::class);
        new RequestLogEntry('');
    }
}
