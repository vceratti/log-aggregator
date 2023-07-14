<?php

declare(strict_types=1);

namespace LogAggregator\Application\Message\Request;

use LogAggregator\Application\Message\MessageInterface;

/** @template-implements MessageInterface<RequestLogRequest> */
class RequestLogRequest implements MessageInterface
{
    public function getStatusCode(): int
    {
        return 0;
    }
}
