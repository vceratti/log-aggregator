<?php

declare(strict_types=1);

namespace LogAggregator\Application\Service\Factory;

use DateTime;
use LogAggregator\Application\Message\InvalidMessageException;
use LogAggregator\Application\Message\RequestLogEntry;
use LogAggregator\Domain\RequestLog;

class RequestLogFactory
{
    /** @throws InvalidMessageException` */
    public function createEntity(RequestLogEntry $requestLogEntry): RequestLog
    {
        return new RequestLog(
            $requestLogEntry->getServiceName(),
            $requestLogEntry->getStatusCode(),
            $requestLogEntry->getQuery(),
            self::createDateTime($requestLogEntry)
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @throws InvalidMessageException
     */
    private function createDateTime(RequestLogEntry $requestLogEntry): DateTime
    {
        $dateTime = DateTime::createFromFormat(RequestLogEntry::LOG_DATE_FORMAT, $requestLogEntry->getDateTime());

        if (!$dateTime instanceof DateTime) {
            throw new InvalidMessageException();
        }

        return $dateTime;
    }
}
