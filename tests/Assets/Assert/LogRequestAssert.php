<?php

declare(strict_types=1);

namespace Tests\Assets\Assert;

use DateTime;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Domain\RequestLog;
use PHPUnit\Framework\TestCase;

class LogRequestAssert
{
    public static function assertEntityMatchesMessage(RequestLogEntry $requestLogEntry, RequestLog $entity): void
    {
        /** @var DateTime $expectedDate */
        $expectedDate = DateTime::createFromFormat(
            RequestLogEntry::LOG_DATE_FORMAT,
            $requestLogEntry->getDateTime()
        );

        TestCase::assertSame($requestLogEntry->getServiceName(), $entity->getServiceName());
        TestCase::assertSame($requestLogEntry->getQuery(), $entity->getQuery());
        TestCase::assertSame($requestLogEntry->getStatusCode(), $entity->getStatusCode());
        TestCase::assertSame($expectedDate->getTimestamp(), $entity->getDateTime()->getTimestamp());
    }
}
