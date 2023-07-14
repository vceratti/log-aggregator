<?php

declare(strict_types=1);

namespace LogAggregator\Application\Factory;

use DateTime;
use LogAggregator\Application\Message\Request\RequestLogRequest;
use LogAggregator\Domain\RequestLog;

class RequestLogFactory
{
    public function createEntity(RequestLogRequest $requestLogDTO): RequestLog
    {
        return new RequestLog(
            '',
            $requestLogDTO->getStatusCode(),
            'rs',
            new DateTime('now')
        );
    }
}
