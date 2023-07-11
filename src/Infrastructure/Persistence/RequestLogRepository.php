<?php

declare(strict_types=1);

namespace LogAggregator\Infrastructure\Persistence;

use LogAggregator\Domain\RequestLog;

interface RequestLogRepository
{
    public function save(RequestLog $request): void;
}
