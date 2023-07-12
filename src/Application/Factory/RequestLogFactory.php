<?php

declare(strict_types=1);

namespace LogAggregator\Application\Factory;

use DateTime;
use LogAggregator\Application\DTO\RequestLogDTO;
use LogAggregator\Domain\RequestLog;

class RequestLogFactory
{
    public function createEntity(RequestLogDTO $requestLogDTO): RequestLog
    {
        $requestLogDTO->validate();

        return new RequestLog(
            1,
            'rs',
            new DateTime('now')
        );
    }
}
