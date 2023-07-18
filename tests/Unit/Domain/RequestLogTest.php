<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use DateTime;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Tests\Assets\Assert\LogRequestAssert;
use Tests\Assets\DataProvider\RequestLogEntryDataProvider;

#[CoversClass(RequestLog::class)]
class RequestLogTest extends TestCase
{
    #[DataProviderExternal(RequestLogEntryDataProvider::class, 'validMessages')]
    public function testEntity(RequestLogEntry $requestLogEntry): void
    {
        /** @var DateTime $dateTime */
        $dateTime = DateTime::createFromFormat(
            RequestLogEntry::LOG_DATE_FORMAT,
            $requestLogEntry->getDateTime()
        );

        $entity = new RequestLog(
            $requestLogEntry->getServiceName(),
            $requestLogEntry->getStatusCode(),
            $requestLogEntry->getQuery(),
            $dateTime
        );

        LogRequestAssert::assertEntityMatchesMessage($requestLogEntry, $entity);
    }
}
